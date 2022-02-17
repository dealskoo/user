<?php

namespace Dealskoo\User\Http\Controllers\Auth;

use Dealskoo\User\Events\UserEmailVerified;
use Dealskoo\User\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param EmailVerificationRequest $request
     * @return RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('user.dashboard', [config('country.prefix') => request()->country()->alpha2, 'verified' => 1]));
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new UserEmailVerified($request->user()));
        }

        return redirect()->intended(route('user.dashboard', [config('country.prefix') => request()->country()->alpha2, 'verified' => 1]));
    }
}
