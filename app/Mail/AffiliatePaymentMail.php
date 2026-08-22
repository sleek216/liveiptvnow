<?php

namespace App\Mail;

use App\Models\Payout;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AffiliatePaymentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Payout $payout;

    public function __construct(Payout $payout)
    {
        $this->payout = $payout->load(['affiliate.user']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Received - $' . number_format($this->payout->amount, 2) . ' | Live IPTV Now',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.affiliate-payment',
            with: [
                'payout' => $this->payout,
                'affiliate' => $this->payout->affiliate,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
