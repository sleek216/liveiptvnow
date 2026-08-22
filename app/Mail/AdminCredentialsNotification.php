<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email sent to ADMIN with credentials for free trials/packages
 * User does NOT receive credentials for free packages - only admin does
 */
class AdminCredentialsNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public array $credentials;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, array $credentials)
    {
        $this->order = $order;
        $this->credentials = $credentials;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Free Trial Credentials - Order #' . $this->order->order_number . ' - ACTION REQUIRED',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.credentials-notification',
            with: [
                'order' => $this->order,
                'credentials' => $this->credentials,
            ],
        );
    }
}
