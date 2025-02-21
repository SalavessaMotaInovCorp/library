<?php

namespace App\Mail;

use App\Models\BookReview;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewBookReviewMail extends Mailable
{
    use Queueable, SerializesModels;

    private BookReview $bookReview;

    /**
     * Create a new message instance.
     */
    public function __construct(BookReview $bookReview)
    {
        $this->bookReview = $bookReview;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Book Review ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new_book_review',
            with: [
                'bookReview' => $this->bookReview,
                'reviewer' => $this->bookReview->user->name,
                'bookTitle' =>$this->bookReview->book->name,
                'rating' => $this->bookReview->rating,
                'comment' => $this->bookReview->comment,
                'reviewLink' => route('book_reviews.edit', $this->bookReview->id),
            ],
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
