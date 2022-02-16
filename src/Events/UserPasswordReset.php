<?php

namespace Dealskoo\User\Events;

use Dealskoo\User\Models\User;
use Illuminate\Queue\SerializesModels;

class UserPasswordReset
{
    use SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
