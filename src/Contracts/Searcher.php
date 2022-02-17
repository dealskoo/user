<?php

namespace Dealskoo\User\Contracts;

use Illuminate\Http\Request;

interface Searcher
{
    public function handle(Request $request);
}
