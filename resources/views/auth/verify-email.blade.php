@extends('user::layouts.auth')

@section('title',__('user::auth.verify_email'))

@section('body')
    <div class="align-items-center d-flex h-100">
        <div class="card-body">

            <!-- Logo -->
            <div class="auth-brand text-center text-lg-end">
                <a href="{{ route('user.dashboard') }}"
                   class="logo-dark">
                    <span><img src="{{ asset(config('user.logo')) }}" alt="" height="40"></span>
                </a>
                <a href="{{ route('user.dashboard') }}"
                   class="logo-light">
                    <span><img src="{{ asset(config('user.logo_dark')) }}" alt="" height="40"></span>
                </a>
            </div>

            <!-- email send icon with text-->
            <div class="text-center m-auto">
                <img src="{{ asset('/vendor/user/images/mail_sent.svg') }}" alt="mail sent image" height="64">
                <h4 class="text-dark-50 text-center mt-4 fw-bold">{{ __('user::auth.please_check_your_email') }}</h4>
                <p class="text-muted mb-4">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </p>
                @if (session('status') == 'verification-link-sent')
                    <p class="text-success mb-4">{{ __('A new verification link has been sent to the email address you provided during registration.') }}</p>
                @endif
            </div>

            <!-- form -->
            <form
                action="{{ route('user.verification.send') }}"
                method="post">
                @csrf
                <div class="mb-0 d-grid text-center">
                    <button class="btn btn-primary" type="submit">
                        {{ __('Resend Verification Email') }}
                    </button>
                </div>
            </form>
            <!-- end form-->

            <!-- Footer-->
            <footer class="footer footer-alt">
                <p class="text-muted">{!! config('user.copyright') !!}</p>
            </footer>

        </div> <!-- end .card-body -->
    </div>
@endsection
