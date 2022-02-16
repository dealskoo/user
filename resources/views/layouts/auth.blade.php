<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>@yield('title') - {{ __('user::auth.title') }} - {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
    <!-- App css -->
    <link href="{{ asset('/vendor/user/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/user/css/app-creative.min.css') }}" rel="stylesheet" type="text/css"
          id="light-style"/>
    <link href="{{ asset('/vendor/user/css/app-creative-dark.min.css') }}" rel="stylesheet" type="text/css"
          id="dark-style"/>
</head>

<body class="authentication-bg pb-0">

<div class="auth-fluid">
    <!--Auth fluid left content -->
    <div class="auth-fluid-form-box">
        @yield('body')
    </div>
    <!-- end auth-fluid-form-box-->

    <!-- Auth fluid right content -->
    <div class="auth-fluid-right text-center">
        <div class="auth-user-testimonial">
            <h2 class="mb-3">{{ __('user::user.auth_title') }}</h2>
            <p class="lead">
                <i class="mdi mdi-format-quote-open"></i>
                {{ __('user::user.auth_description') }}
                <i class="mdi mdi-format-quote-close"></i>
            </p>
            <p>
                - {{ config('app.name') }}
            </p>
        </div> <!-- end auth-user-testimonial-->
    </div>
    <!-- end Auth fluid right content -->
</div>
<!-- end auth-fluid-->

<!-- bundle -->
<script src="{{ asset('/vendor/user/js/vendor.min.js') }}"></script>
<script src="{{ asset('/vendor/user/js/app.min.js') }}"></script>

</body>

</html>
