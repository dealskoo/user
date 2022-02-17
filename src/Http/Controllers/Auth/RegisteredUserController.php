<?php

namespace Dealskoo\User\Http\Controllers\Auth;

use Dealskoo\User\Http\Controllers\Controller;
use Dealskoo\User\Models\User;
use Dealskoo\Country\Models\Country;
use Dealskoo\User\Events\UserRegistered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $countries = Country::all();
        return view('user::auth.register', ['countries' => $countries]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::min(config('auth.password_length'))],
            'country_id' => ['required', 'exists:countries,id']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country_id' => $request->country_id,
            'source' => $request->source,
        ]);
        event(new UserRegistered($user));

        $this->guard()->login($user);

        return redirect(route('user.dashboard'));
    }
}
