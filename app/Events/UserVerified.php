<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class UserVerified
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public readonly Object $user;
    public readonly Bool $admin_verified;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, bool $admin_verified = false)
    {
        $this->user = vlx_cast_to_object($user->only(['name', 'email', 'uuid', 'id']));
        $this->admin_verified = $admin_verified;
    }
}
