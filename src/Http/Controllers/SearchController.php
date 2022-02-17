<?php

namespace Dealskoo\User\Http\Controllers;

use Dealskoo\User\Contracts\Searcher;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function handle(Request $request, Searcher $searcher)
    {
        return $searcher->handle($request);
    }
}
