<?php

namespace Dealskoo\User\Events;

use Dealskoo\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
