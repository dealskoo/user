<?php

namespace Dealskoo\User\Contracts\Support;

use Dealskoo\User\Contracts\Searcher;
use Illuminate\Http\Request;

class DefaultSearcher implements Searcher
{
    public function handle(Request $request)
    {
        return view('user::dashboard');
    }
}
