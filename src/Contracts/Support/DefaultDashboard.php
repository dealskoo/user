<?php

namespace Dealskoo\User\Contracts\Support;

use Dealskoo\User\Contracts\Dashboard;
use Illuminate\Http\Request;

class DefaultDashboard implements Dashboard
{
    public function handle(Request $request)
    {
        return view('user::dashboard');
    }
}
