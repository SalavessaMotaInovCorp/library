<?php

namespace App\Jobs;

use App\Mail\BookAvailableNotification;
use App\Models\Book;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendBookAvailableEmail implements ShouldQueue
{
    use Queueable;

    protected $book;

    /**
     * Create a new job instance.
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $interestedUsers = $this->book->interestedUsers;

        foreach ($interestedUsers as $user) {
            Mail::to($user->email)->send(new BookAvailableNotification($this->book));
        }

        $this->book->interestedUsers()->detach();
    }
}
