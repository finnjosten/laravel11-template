<?php

namespace App\Listeners;

use App\Events\UserDestroyed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

use \App\Mail\UserDestroyedMail;

class UserDestroyedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserDestroyed $event) {
        $user = $event->user;

        // Send email to user notifying them of account deletion
        Mail::to($user->email)->send(new UserDestroyedMail($user));

        return "Mail sent to " . $user->email;
    }
}
