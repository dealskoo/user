<?php

namespace Dealskoo\User\Http\Controllers;

use Dealskoo\User\Notifications\EmailChangeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;

class AccountController extends Controller
{

    public function store(Request $request)
    {
        $user = $request->user();
        if ($user->slug) {
            $request->validate([
                'name' => ['required', 'unique:users,name,' . $request->user()->id . ',id'],
            ]);
            $user->fill($request->only(['name', 'bio', 'company_name', 'website']));
        } else {
            $request->validate([
                'name' => ['required', 'unique:users,name,' . $request->user()->id . ',id'],
                'slug' => ['required', 'regex:/^[\w\d_]+$/i', 'unique:users,slug,' . $request->user()->id . ',id'],
            ]);
            $user->fill($request->only(['name', 'bio', 'company_name', 'website', 'slug']));
        }
        $user->save();
        return back()->with('success', __('user::user.update_success'));
    }

    public function avatar(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'max:1000']
        ]);

        $image = $request->file('file');
        $user = $request->user();
        $filename = $user->id . '.' . $image->guessExtension();
        $path = $image->storeAs('user/avatars', $filename);
        $user->avatar = $path;
        $user->save();
        return ['url' => $user->avatar_url];
    }

    public function email(Request $request)
    {
        $request->validate(['email' => ['required', 'email', 'unique:users']]);
        Notification::route('mail', $request->input('email'))->notify(new EmailChangeNotification());
        return back()->withInput($request->only(['email']))->with('success', __('Email Verify Notification Send Success'));
    }

    public function emailVerify(Request $request)
    {
        $email = Session::get('user_email_change_verify');
        if (hash_equals($request->route('hash'), sha1($email))) {
            $user = $request->user();
            $user->email = $email;
            $user->save();
            return redirect()->route('user.account.email', [config('country.prefix') => request()->country()->alpha2])->with('success', __('Email Change Success'));
        } else {
            return redirect()->route('user.account.email', [config('country.prefix') => request()->country()->alpha2])->withErrors([__('Link expired')]);
        }
    }

    public function password(Request $request)
    {
        $request->validate([
            'password' => ['required', Rules\Password::min(config('auth.password_length'))],
            'new_password' => ['required', 'confirmed', Rules\Password::min(config('auth.password_length'))],
        ]);

        if (!$this->guard()->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            return back()->withErrors([
                'password' => [__('The provided password does not match our records.')]
            ]);
        } else {
            $user = $request->user();
            $user->password = Hash::make($request->input('new_password'));
            $user->save();
            return back()->with('success', __('user::user.update_success'));
        }
    }
}
