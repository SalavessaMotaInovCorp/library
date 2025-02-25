<?php

namespace App\Jobs;

use App\Mail\AbandonedCartReminder;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendAbandonedCartReminder implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $oneHourAgo = Carbon::now()->subHour();

        $usersWithAbandonedCarts = CartItem::where('created_at', '<=', $oneHourAgo)
            ->groupBy('user_id')
            ->pluck('user_id');

        foreach ($usersWithAbandonedCarts as $userId) {
            $user = User::find($userId);
            if ($user) {
                Mail::to($user->email)->send(new AbandonedCartReminder($user));
            }
        }
    }
}
