<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Package;
use App\Mail\OrderDetailsMail;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'package']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number or customer
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function markAllAsRead(): RedirectResponse
    {
        $count = Order::where('is_read', false)->update(['is_read' => true]);
        return redirect()
            ->back()
            ->with('success', "Marked {$count} unread order(s) as read. Count reset to 0.");
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'package', 'countries']);

        // Mark as read if not already
        if (!$order->is_read) {
            $order->update(['is_read' => true]);
        }

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,processing,completed,cancelled',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $order->update($validated);

        // If marked as completed, set activation dates
        if ($validated['order_status'] === 'completed' && !$order->activated_at) {
            $order->markAsCompleted();
        }

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully!');
    }

    public function updatePaymentStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,completed,failed,refunded',
        ]);

        $wasCompleted = $order->payment_status === 'completed';
        $order->update($validated);

        if (!$wasCompleted && $validated['payment_status'] === 'completed') {
            $order->processAffiliateCommissionIfPaid();
        }

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Payment status updated successfully!');
    }

    public function sendEmail(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'include_credentials' => 'boolean',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'm3u_url' => 'nullable|string|max:500',
            'portal_url' => 'nullable|string|max:500',
        ]);

        try {
            Mail::to($order->customer_email)
                ->send(new OrderDetailsMail($order, $validated));

            $updateData = ['email_sent_at' => now()];
            if ($request->filled('portal_url')) {
                $updateData['portal_url'] = $validated['portal_url'];
            }
            $order->update($updateData);

            return redirect()
                ->route('admin.orders.show', $order)
                ->with('success', 'Email sent successfully to ' . $order->customer_email);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.orders.show', $order)
                ->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    public function invoice(Order $order): View
    {
        $order->load(['user', 'package', 'countries']);
        return view('admin.orders.invoice', compact('order'));
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->countries()->detach();
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order deleted successfully!');
    }
    public function create(): View
    {
        $packages = Package::active()->get();
        return view('admin.orders.create', compact('packages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'adjustment_amount' => 'nullable|numeric',
            'order_status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'required|in:pending,completed,failed,refunded',
            'notes' => 'nullable|string',
        ]);

        $package = Package::find($validated['package_id']);
        $user = User::find($validated['user_id']);
        
        $adjustment = $validated['adjustment_amount'] ?? 0;
        $totalAmount = $package->price + $adjustment;

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => $user->id,
            'package_id' => $package->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'amount' => $totalAmount,
            'adjustment_amount' => $adjustment,
            'order_status' => $validated['order_status'],
            'payment_status' => $validated['payment_status'],
            'notes' => $validated['notes'],
        ]);

        if ($validated['payment_status'] === 'completed') {
            $order->processAffiliateCommissionIfPaid();
        }

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Order created successfully!');
    }

    public function edit(Order $order): View
    {
        $packages = Package::all();
        return view('admin.orders.edit', compact('order', 'packages'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'adjustment_amount' => 'nullable|numeric',
            'coupon_code' => 'nullable|string|max:50',
            'order_status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'required|in:pending,completed,failed,refunded',
            'admin_notes' => 'nullable|string',
        ]);

        $adjustment = $validated['adjustment_amount'] ?? 0;
        
        // If package exists, recalculate based on package price + adjustment
        if ($order->package) {
            $basePrice = $order->package->price;
            $newAmount = $basePrice + $adjustment;
        } else {
            // Fallback if no package (shouldn't happen often but safely handle)
            $newAmount = $order->amount + ($adjustment - $order->adjustment_amount); 
        }

        $wasCompleted = $order->payment_status === 'completed';

        $order->update([
            'amount' => $newAmount,
            'adjustment_amount' => $adjustment,
            'coupon_code' => $validated['coupon_code'],
            'order_status' => $validated['order_status'],
            'payment_status' => $validated['payment_status'],
            'admin_notes' => $validated['admin_notes'],
        ]);

        if (!$wasCompleted && $validated['payment_status'] === 'completed') {
            $order->processAffiliateCommissionIfPaid();
        }

        if ($validated['order_status'] === 'completed' && !$order->activated_at) {
            $order->markAsCompleted();
        }

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Order updated successfully. New Total: $' . number_format($newAmount, 2));
    }

    public function searchUser(Request $request)
    {
        $search = $request->get('q');
        $users = User::where('email', 'like', "%{$search}%")
            ->orWhere('name', 'like', "%{$search}%")
            ->limit(10)
            ->get(['id', 'name', 'email']);
            
        return response()->json($users);
    }

    public function bulkUpdateStatus(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_ids' => 'required|array|min:1',
            'order_ids.*' => 'exists:orders,id',
            'bulk_order_status' => 'nullable|in:pending,processing,completed,cancelled',
            'bulk_payment_status' => 'nullable|in:pending,completed,failed,refunded',
        ]);

        if (empty($validated['bulk_order_status']) && empty($validated['bulk_payment_status'])) {
            return redirect()
                ->route('admin.orders.index', $request->only(['search', 'status', 'payment_status']))
                ->with('error', 'Please select at least one status (Order Status or Payment Status) to update.');
        }

        $orders = Order::whereIn('id', $validated['order_ids'])->get();
        $count = 0;

        foreach ($orders as $order) {
            $updateData = [];

            if (!empty($validated['bulk_order_status'])) {
                $updateData['order_status'] = $validated['bulk_order_status'];
            }

            if (!empty($validated['bulk_payment_status'])) {
                $wasPaymentCompleted = $order->payment_status === 'completed';
                $updateData['payment_status'] = $validated['bulk_payment_status'];
                if (!$wasPaymentCompleted && $validated['bulk_payment_status'] === 'completed') {
                    $order->processAffiliateCommissionIfPaid();
                }
            }

            if (!empty($updateData)) {
                $order->update($updateData);

                if (!empty($validated['bulk_order_status']) && $validated['bulk_order_status'] === 'completed' && !$order->activated_at) {
                    $order->markAsCompleted();
                }
            }

            $count++;
        }

        $messages = [];
        if (!empty($validated['bulk_order_status'])) {
            $messages[] = 'Order Status to "' . ucfirst($validated['bulk_order_status']) . '"';
        }
        if (!empty($validated['bulk_payment_status'])) {
            $messages[] = 'Payment Status to "' . ucfirst($validated['bulk_payment_status']) . '"';
        }
        $msgString = implode(' and ', $messages);

        return redirect()
            ->route('admin.orders.index', $request->only(['search', 'status', 'payment_status']))
            ->with('success', "Updated {$msgString} for {$count} order(s).");
    }
}
