<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Trader;

class TraderStatusUpdateEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $trader;
    public $status;

    /**
     * Create a new message instance.
     */
    public function __construct(Trader $trader, string $status)
    {
        $this->trader = $trader;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->status === 'approved' 
            ? 'Your Trader Account Has Been Approved' 
            : 'Your Trader Account Application Status Update';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.trader-status-update',
            with: [
                'trader' => $this->trader,
                'status' => $this->status,
            ],
        );
    }
} 