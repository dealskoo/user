<?php

namespace Dealskoo\User\Http\Controllers\Auth;

use Dealskoo\User\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('dashboard', [config('country.prefix') => request()->country()->alpha2]))
            : view('user::auth.verify-email');
    }
}
