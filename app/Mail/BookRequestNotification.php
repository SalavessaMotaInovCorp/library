<?php

namespace App\Mail;

use App\Models\BookRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    private BookRequest $bookRequest;
    private mixed $recipient;
    /**
     * @var false|mixed
     */
    private bool $isUser;

    /**
     * Create a new message instance.
     */
    public function __construct(BookRequest $bookRequest, $recipient, $isUser = false)
    {
        $this->bookRequest = $bookRequest;
        $this->recipient = $recipient;
        $this->isUser = $isUser;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->isUser
                ? 'Book Request Confirmation'
                : 'New Book Request Notification'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.book_request_notification',
            with: [
                'bookRequest' => $this->bookRequest,
                'recipient' => $this->recipient,
                'book' => $this->bookRequest->book,
                'isUser' => $this->isUser,
            ]
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
