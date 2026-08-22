<?php

namespace App\Mail;

use App\Models\Commission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommissionApprovedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Commission $commission;

    public function __construct(Commission $commission)
    {
        $this->commission = $commission->load(['affiliate.user', 'order.package', 'referral.referredUser']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Referral Commission Has Been Approved - $' . number_format($this->commission->commission_amount, 2),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.commission-approved',
            with: [
                'commission' => $this->commission,
                'affiliate' => $this->commission->affiliate,
                'buyer' => $this->commission->referral->referredUser ?? null,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
