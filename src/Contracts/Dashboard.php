<?php

namespace Dealskoo\User\Contracts;

use Illuminate\Http\Request;

interface Dashboard
{
    public function handle(Request $request);
}
