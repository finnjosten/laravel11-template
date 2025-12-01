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
use stdClass;

class UserDestroyed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public readonly Object $user;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user)
    {
        $this->user = vlx_cast_to_object($user->only(['name', 'email', 'uuid', 'id']));
    }
}
