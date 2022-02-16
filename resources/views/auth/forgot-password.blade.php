@extends('user::layouts.auth')

@if(!empty(session('status')))
    @section('title',__('user::auth.confirm_email'))
@else
    @section('title',__('user::auth.recover_password'))
@endif

@section('body')
    @if(!empty(session('status')))
        <div class="align-items-center d-flex h-100">
            <div class="card-body">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-end">
                    <a href="{{ route('user.dashboard',[config('country.prefix')=>request()->country()->alpha2]) }}"
                       class="logo-dark">
                        <span><img src="{{ asset(config('user.logo')) }}" alt="" height="40"></span>
                    </a>
                    <a href="{{ route('user.dashboard',[config('country.prefix')=>request()->country()->alpha2]) }}"
                       class="logo-light">
                        <span><img src="{{ asset(config('user.logo_dark')) }}" alt="" height="40"></span>
                    </a>
                </div>

                <!-- email send icon with text-->
                <div class="text-center m-auto">
                    <img src="{{ asset('/vendor/user/images/mail_sent.svg') }}" alt="mail sent image" height="64">
                    <h4 class="text-dark-50 text-center mt-4 fw-bold">{{ __('user::auth.please_check_your_email') }}</h4>
                    <p class="text-muted mb-4">
                        {!! __('user::auth.a_email_has_been_send_to',['email'=>old('email'),'company'=>config('app.name')]) !!}
                    </p>
                </div>

                <!-- form -->
                <form action="{{ route('user.dashboard',[config('country.prefix')=>request()->country()->alpha2]) }}">
                    <div class="mb-0 d-grid text-center">
                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-home me-1"></i>
                            {{ __('user::auth.back_to') }} {{ __('user::auth.login') }}
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
    @else
        <div class="align-items-center d-flex h-100">
            <div class="card-body">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start">
                    <a href="{{ route('user.dashboard',[config('country.prefix')=>request()->country()->alpha2]) }}"
                       class="logo-dark">
                        <span><img src="{{ asset(config('user.logo')) }}" alt="" height="40"></span>
                    </a>
                    <a href="{{ route('user.dashboard',[config('country.prefix')=>request()->country()->alpha2]) }}"
                       class="logo-light">
                        <span><img src="{{ asset(config('user.logo_dark')) }}" alt="" height="40"></span>
                    </a>
                </div>

                <!-- title-->
                <h4 class="mt-0">{{ __('user::auth.reset_password') }}</h4>
                <div class="mb-4">
                    @if(empty($errors->all()))
                        <p class="text-muted mb-0">{{ __('user::auth.reset_password_tip') }}</p>
                    @else
                        @foreach($errors->all() as $error)
                            <p class="text-danger mb-0">{{ $error }}</p>
                        @endforeach
                    @endif
                </div>

                <!-- form -->
                <form
                    action="{{ route('user.password.email',[config('country.prefix')=>request()->country()->alpha2]) }}"
                    method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('user::auth.email_address') }}</label>
                        <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}"
                               required="" autofocus tabindex="1"
                               placeholder="{{ __('user::auth.email_address_placeholder') }}">
                    </div>
                    <div class="mb-0 text-center d-grid">
                        <button class="btn btn-primary" type="submit" tabindex="2"><i
                                class="mdi mdi-lock-reset"></i> {{ __('user::auth.reset_password') }}
                        </button>
                    </div>
                </form>
                <!-- end form-->

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">{{ __('user::auth.back_to') }} <a
                            href="{{ route('user.login',[config('country.prefix')=>request()->country()->alpha2]) }}"
                            class="text-muted ms-1"><b>{{ __('user::auth.log_in') }}</b></a>
                    </p>
                </footer>

            </div> <!-- end .card-body -->
        </div> <!-- end .align-items-center.d-flex.h-100-->
    @endif
@endsection
