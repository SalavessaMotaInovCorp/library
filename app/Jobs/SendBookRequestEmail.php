<?php

namespace App\Jobs;

use App\Mail\BookRequestNotification;
use App\Models\BookRequest;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendBookRequestEmail implements ShouldQueue
{
    use Queueable;

    protected BookRequest $bookRequest;
    protected User $recipient;
    protected bool $isUser;

    /**
     * Create a new job instance.
     */
    public function __construct(BookRequest $bookRequest, User $recipient, bool $isUser = false)
    {
        $this->bookRequest = $bookRequest;
        $this->recipient = $recipient;
        $this->isUser = $isUser;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->recipient->email)
            ->send(new BookRequestNotification($this->bookRequest, $this->recipient, $this->isUser));
    }
}
