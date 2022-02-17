<?php

namespace Dealskoo\User\Http\Controllers;

use Dealskoo\User\Contracts\Dashboard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function handle(Request $request, Dashboard $dashboard)
    {
        return $dashboard->handle($request);
    }
}
