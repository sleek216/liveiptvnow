<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #1f2937;
            line-height: 1.5;
            margin: 0;
            padding: 40px;
            background: #fff;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 3rem;
        }
        .brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 0.5rem;
        }
        .invoice-title {
            font-size: 1.875rem;
            font-weight: 700;
            text-align: right;
            color: #111827;
        }
        .invoice-meta {
            text-align: right;
            color: #6b7280;
            font-size: 0.875rem;
        }
        .meta-group {
            margin-top: 0.5rem;
        }
        .addresses {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3rem;
            font-size: 0.9375rem;
        }
        .address-group h3 {
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        .address-group p {
            margin: 0.25rem 0;
        }
        .table-container {
            margin-bottom: 3rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            text-align: left;
            padding: 0.75rem 0;
            border-bottom: 2px solid #e5e7eb;
            font-weight: 600;
            font-size: 0.875rem;
        }
        td {
            padding: 1rem 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.9375rem;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            width: 300px;
            margin-left: auto;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-size: 0.9375rem;
        }
        .total-row.final {
            border-top: 2px solid #e5e7eb;
            margin-top: 0.5rem;
            padding-top: 1rem;
            font-weight: 700;
            font-size: 1.125rem;
        }
        .footer {
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
        }
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            background: #e5e7eb;
            color: #374151;
            margin-top: 1rem;
        }
        .print-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: #2563eb;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: background 0.2s;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .print-btn:hover {
            background: #1d4ed8;
        }
        @media print {
            body { padding: 0; background: white; }
            .print-btn { display: none; }
            .invoice-container { max-width: 100%; }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256"><path d="M222,72H182V32a6,6,0,0,0-6-6H80a6,6,0,0,0-6,6V72H34A14,14,0,0,0,20,86V184a14,14,0,0,0,14,14H46v22a6,6,0,0,0,6,6H204a6,6,0,0,0,6-6V198h26a14,14,0,0,0,14-14V86A14,14,0,0,0,222,72ZM86,38h84V72H86ZM204,208H52V162H204Zm26-24a2,2,0,0,1-2,2H210V156a6,6,0,0,0-6-6H52a6,6,0,0,0-6,6v30H34a2,2,0,0,1-2-2V86a2,2,0,0,1,2-2H222a2,2,0,0,1,2,2Zm-34-84a10,10,0,1,1,10-10A10,10,0,0,1,196,100Z"></path></svg>
        Print Invoice
    </button>

    <div class="invoice-container">
        <div class="header">
            <div>
                <div class="brand">Live IPTV Now</div>
                <div>Premium IPTV Services</div>
                <div>support@Live IPTV Now.com</div>
            </div>
            <div>
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-meta">
                    <div class="meta-group">
                        #{{ $order->order_number }}
                    </div>
                    <div class="meta-group">
                        Date: {{ $order->created_at->format('M d, Y') }}
                    </div>
                    <div class="status-badge" style="background: {{ $order->payment_status === 'completed' ? '#dcfce7' : '#f3f4f6' }}; color: {{ $order->payment_status === 'completed' ? '#166534' : '#374151' }}">
                        {{ strtoupper($order->payment_status) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="addresses">
            <div class="address-group">
                <h3>Billed To</h3>
                <p><strong>{{ $order->customer_name }}</strong></p>
                <p>{{ $order->customer_email }}</p>
                @if($order->customer_phone)
                <p>{{ $order->customer_phone }}</p>
                @endif
                @if($order->selected_countries)
                <p class="text-sm text-muted mt-2">
                    Region: {{ count($order->countries) }} Countries selected
                </p>
                @endif
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div><strong>{{ $order->package->name ?? 'Custom Package' }}</strong></div>
                            @if($order->package)
                            <div style="font-size: 0.8125rem; color: #6b7280; margin-top: 0.25rem;">
                                {{ $order->package->duration_label ?? $order->package->duration }} Subscription
                                • {{ $order->package->devices }} Device(s)
                            </div>
                            @endif
                        </td>
                        <td class="text-right">${{ number_format($order->package->price ?? $order->amount, 2) }}</td>
                        <td class="text-right">${{ number_format($order->package->price ?? $order->amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="totals">
            @php
                $subtotal = $order->package->price ?? $order->amount;
            @endphp
            
            <div class="total-row">
                <span>Subtotal</span>
                <span>${{ number_format($subtotal, 2) }}</span>
            </div>

            @if($order->discount_amount > 0)
            <div class="total-row" style="color: #166534;">
                <span>Discount @if($order->coupon_code) ({{ $order->coupon_code }}) @endif</span>
                <span>-${{ number_format($order->discount_amount, 2) }}</span>
            </div>
            @endif

            @if($order->adjustment_amount != 0)
            <div class="total-row">
                <span>Adjustment</span>
                <span>{{ $order->adjustment_amount > 0 ? '+' : '' }}${{ number_format($order->adjustment_amount, 2) }}</span>
            </div>
            @endif

            <div class="total-row final">
                <span>Total</span>
                <span>${{ number_format($order->amount, 2) }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for choosing Live IPTV Now!</p>
            <p style="margin-top: 0.5rem; font-size: 0.75rem;">
                If you have any questions about this invoice, please contact our support team.
            </p>
        </div>
    </div>
</body>
</html>
