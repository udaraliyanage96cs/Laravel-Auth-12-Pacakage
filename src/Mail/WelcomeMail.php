<?php

namespace Udara\LaravelAuth\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address', env('MAIL_FROM_ADDRESS', 'admin@example.com'));
        $fromName = config('mail.from.name', env('MAIL_FROM_NAME', env('APP_NAME', 'Laravel Auth')));

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: 'Welcome to ' . config('app.name', env('APP_NAME', 'Laravel Auth')),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
