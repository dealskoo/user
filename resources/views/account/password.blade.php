@extends('seller::layouts.panel')

@section('title',__('seller::seller.update_password'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('seller.dashboard') }}">{{ __('seller::seller.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('seller::seller.update_password') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('seller::seller.update_password') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-5">
            @include('seller::includes.profile')
        </div> <!-- end col-->

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('seller.account.password') }}" method="post">
                        @csrf
                        <h5 class="mb-4 text-uppercase"><i
                                class="mdi mdi-lock-outline me-1"></i> {{ __('seller::seller.update_password') }}</h5>
                        @if(!empty(session('success')))
                            <div class="alert alert-success">
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        @endif
                        @if(!empty($errors->all()))
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="password"
                                           class="form-label">{{ __('seller::seller.password') }}</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" required
                                               minlength="{{ config('auth.password_length') }}" name="password" autofocus
                                               tabindex="1"
                                               placeholder="{{ __('seller::seller.password_placeholder') }}">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="new_password"
                                           class="form-label">{{ __('seller::seller.new_password') }}</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="new_password"
                                               name="new_password"
                                               minlength="{{ config('auth.password_length') }}" tabindex="2"
                                               placeholder="{{ __('seller::seller.new_password_placeholder') }}">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="confirm_new_password"
                                           class="form-label">{{ __('seller::seller.confirm_new_password') }}</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_new_password"
                                               name="new_password_confirmation" required tabindex="3"
                                               minlength="{{ config('auth.password_length') }}"
                                               placeholder="{{ __('seller::seller.confirm_new_password_placeholder') }}">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2" tabindex="4"><i
                                    class="mdi mdi-content-save"></i> {{ __('seller::seller.save') }}
                            </button>
                        </div>
                    </form>
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
@endsection
