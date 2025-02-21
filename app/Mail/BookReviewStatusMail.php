<?php

namespace App\Mail;

use App\Models\BookReview;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookReviewStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public BookReview $bookReview;
    public string $status;
    public ?string $justification;


    /**
     * Create a new message instance.
     */
    public function __construct(BookReview $bookReview)
    {
        $this->bookReview = $bookReview;
        $this->status = $bookReview->status;
        $this->justification = $bookReview->justification ?? null;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Book Review Status Update',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.book_review_status',
            with: [
                'bookReview' => $this->bookReview,
                'status' => $this->status,
                'justification' => $this->justification,
                'bookTitle' => $this->bookReview->book->name,
                'reviewLink' => route('book_reviews.edit', $this->bookReview->id),
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
