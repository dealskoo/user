@extends('user::layouts.auth')

@section('title',__('user::auth.create_new_password'))

@section('body')
    <div class="align-items-center d-flex h-100">
        <div class="card-body">

            <!-- Logo -->
            <div class="auth-brand text-center text-lg-start">
                <a href="{{ route('user.dashboard') }}"
                   class="logo-dark">
                    <span><img src="{{ asset(config('user.logo')) }}" alt="" height="40"></span>
                </a>
                <a href="{{ route('user.dashboard') }}"
                   class="logo-light">
                    <span><img src="{{ asset(config('user.logo_dark')) }}" alt="" height="40"></span>
                </a>
            </div>

            <!-- title-->
            <h4 class="mt-0">{{ __('user::auth.create_new_password') }}</h4>
            <div class="mb-4">
                @if(empty($errors->all()))
                    <p class="text-muted mb-0">{{ __('user::auth.create_new_password_tip',['length'=>config('auth.password_length')]) }}</p>
                @else
                    @foreach($errors->all() as $error)
                        <p class="text-danger mb-0">{{ $error }}</p>
                    @endforeach
                @endif
            </div>
            <!-- form -->
            <form action="{{ route('user.password.update') }}"
                  method="post">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('user::auth.email_address') }}</label>
                    <input class="form-control" type="email" id="email" name="email"
                           value="{{ old('email',$request->email) }}" required autofocus tabindex="1"
                           placeholder="{{ __('user::auth.email_address_placeholder') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('user::auth.password') }}</label>
                    <div class="input-group">
                        <input class="form-control" type="password" required id="password" name="password"
                               minlength="{{ config('auth.password_length') }}" tabindex="2"
                               placeholder="{{ __('user::auth.password_placeholder') }}">
                        <div class="input-group-text" data-password="false">
                            <span class="password-eye"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation"
                           class="form-label">{{ __('user::auth.confirm_password') }}</label>
                    <div class="input-group">
                        <input class="form-control" type="password" required id="password_confirmation"
                               name="password_confirmation" tabindex="3"
                               minlength="{{ config('auth.password_length') }}"
                               placeholder="{{ __('user::auth.confirm_password_placeholder') }}">
                        <div class="input-group-text" data-password="false">
                            <span class="password-eye"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-0 d-grid text-center">
                    <button class="btn btn-primary" type="submit" tabindex="4"><i
                            class="mdi mdi-account-circle"></i> {{ __('user::auth.create_new_password') }}
                    </button>
                </div>
            </form>
            <!-- end form-->
        </div> <!-- end .card-body -->
    </div> <!-- end .align-items-center.d-flex.h-100-->
@endsection
