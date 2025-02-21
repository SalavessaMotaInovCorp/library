<?php

namespace App\Mail;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookAvailableNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $book;

    /**
     * Create a new message instance.
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Book Available Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.book_available',
            with: [
                'bookTitle' => $this->book->name,
                'bookLink' => route('books.show', $this->book),
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
