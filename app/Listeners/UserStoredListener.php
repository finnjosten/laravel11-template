<?php

namespace App\Listeners;

use App\Events\UserStored;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

use \App\Mail\UserStoredMail;
use App\Models\User;

class UserStoredListener implements ShouldQueue
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
    public function handle(UserStored $event) {
        $user = $event->user;

        // Send email to user notifying them of account creation
        Mail::to($user->email)->send(new UserStoredMail($user));

        return "Mail sent to " . $user->email;
    }
}
