<?php

namespace Dealskoo\User\Facades;

use Illuminate\Support\Facades\Facade;

class UserMenu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'user_menu';
    }

}
