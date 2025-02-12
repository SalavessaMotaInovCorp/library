<?php

namespace App\Jobs;

use App\Mail\DueDateReminder;
use App\Models\BookRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendDueDateReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {

    }

    public function __invoke(): void
    {
        $tomorrow = now()->addDay()->toDateString();

        $bookRequests = BookRequest::whereDate('due_date', $tomorrow)
            ->where('status', 'active')
            ->get();

        foreach ($bookRequests as $request) {
            Mail::to($request->user_email)
                ->send(new DueDateReminder($request));
        }
    }
}
