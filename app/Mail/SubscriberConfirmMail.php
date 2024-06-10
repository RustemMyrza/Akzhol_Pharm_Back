<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriberConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $token;
    public string $email;

    /**
     * Create a new message instance.
     */
    public function __construct(object $subscriber)
    {
        $this->token = $subscriber->token;
        $this->email = $subscriber->email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: trans('message.subscribe_confirm_subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $verifyLink = url("api/V1/subscriber/verify/{$this->token}/{$this->email}");
        return new Content(
            view: 'mail.subscribeConfirm',
            with: ['verifyLink' => $verifyLink]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
