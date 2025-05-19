<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Trader;

class TraderWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $trader;

    /**
     * Create a new message instance.
     */
    public function __construct(Trader $trader)
    {
        $this->trader = $trader;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to FreshBlink Trader Program',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.trader_welcome',
            with: [
                'trader' => $this->trader,
            ],
        );
    }
} 