<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .info-row {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .value {
            color: #1f2937;
            font-size: 16px;
        }
        .message-box {
            background: #f9fafb;
            border-left: 4px solid #0066ff;
            padding: 15px;
            border-radius: 4px;
            margin-top: 10px;
        }
        .footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            background: #dbeafe;
            color: #1e40af;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 New Contact Form Submission</h1>
        </div>
        
        <div class="content">
            <p style="margin-top: 0;">You have received a new message from the contact form on Live IPTV Now.</p>
            
            <div class="info-row">
                <div class="label">From</div>
                <div class="value">{{ $contact->name }}</div>
            </div>
            
            <div class="info-row">
                <div class="label">Email</div>
                <div class="value">
                    <a href="mailto:{{ $contact->email }}" style="color: #0066ff; text-decoration: none;">
                        {{ $contact->email }}
                    </a>
                </div>
            </div>
            
            @if($contact->phone)
            <div class="info-row">
                <div class="label">Phone</div>
                <div class="value">{{ $contact->phone }}</div>
            </div>
            @endif
            
            <div class="info-row">
                <div class="label">Subject</div>
                <div class="value">
                    <span class="badge">{{ $contact->subject }}</span>
                </div>
            </div>
            
            <div class="info-row">
                <div class="label">Message</div>
                <div class="message-box">
                    {{ $contact->message }}
                </div>
            </div>
            
            <div class="info-row">
                <div class="label">Submitted At</div>
                <div class="value">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
        </div>
        
        <div class="footer">
            <p style="margin: 0;">This is an automated message from Live IPTV Now Contact Form</p>
            <p style="margin: 5px 0 0 0;">© {{ date('Y') }} Live IPTV Now. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
