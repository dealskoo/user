<?php

namespace Dealskoo\User\Traits;

use Dealskoo\User\Models\User;

trait HasUser
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
