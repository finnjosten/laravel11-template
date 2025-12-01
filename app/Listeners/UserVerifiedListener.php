<?php

namespace App\Listeners;

use App\Events\UserVerified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserVerifiedMail;

class UserVerifiedListener implements ShouldQueue
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
    public function handle(UserVerified $event) {
        $user = $event->user;
        $admin_verified = $event->admin_verified;

        // Send email to user notifying them of account deletion
        Mail::to($user->email)->send(new UserVerifiedMail($user, $admin_verified));

        return "Mail sent to " . $user->email;
    }
}
