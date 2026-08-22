<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public array $emailData
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailData['subject'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-details',
            with: [
                'order' => $this->order,
                'emailMessage' => $this->emailData['message'],
                'includeCredentials' => $this->emailData['include_credentials'] ?? false,
                'username' => $this->emailData['username'] ?? null,
                'password' => $this->emailData['password'] ?? null,
                'm3uUrl' => $this->emailData['m3u_url'] ?? null,
                'portalUrl' => $this->emailData['portal_url'] ?? null,
            ],
        );
    }
}
