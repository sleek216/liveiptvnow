<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Setting;
use App\Mail\ContactFormSubmitted;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'subject.required' => 'Please select a subject.',
            'message.required' => 'Please enter your message.',
            'message.max' => 'Your message is too long. Please keep it under 5000 characters.',
        ]);

        // Create contact record
        $contact = Contact::create($validated);

        try {
            $adminEmail = Setting::get('admin_notification_email')
                ?: config('mail.from.address');

            Mail::to($adminEmail)
                ->send(new ContactFormSubmitted($contact));
        } catch (\Exception $e) {
            Log::error('Failed to send contact form email: ' . $e->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', 'Thank you for contacting us! We will get back to you within 24 hours.');
    }
}
