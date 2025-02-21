<?php

namespace App\Jobs;

use App\Mail\NewBookReviewMail;
use App\Models\BookReview;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewBookReviewEmailToAdmins implements ShouldQueue
{
    use Queueable, InteractsWithQueue, Queueable, SerializesModels;

    protected BookReview $bookReview;

    /**
     * Create a new job instance.
     */
    public function __construct(BookReview $bookReview)
    {
        $this->bookReview = $bookReview;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new NewBookReviewMail($this->bookReview));
        }
    }

}
