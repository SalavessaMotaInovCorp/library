<?php

namespace App\Mail;

use App\Models\Book;
use App\Models\BookRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DueDateReminder extends Mailable
{
    use Queueable, SerializesModels;

    public BookRequest $bookRequest;
    public Book $book;

    /**
     * Create a new message instance.
     */
    public function __construct(BookRequest $bookRequest)
    {
        $this->bookRequest = $bookRequest;
        $this->book = Book::find($bookRequest->book_id);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Book Request Due Date Reminder',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.due_date_reminder',
            with: [
                'userName' => $this->bookRequest->user_name,
                'bookRequest' => $this->bookRequest,
                'book' => $this->book,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
