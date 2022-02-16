@extends('seller::layouts.panel')

@section('title',__('seller::seller.my_account'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('seller.dashboard') }}">{{ __('seller::seller.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('seller::seller.my_account') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('seller::seller.my_account') }}</h4>
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
                    <form action="{{ route('seller.account.profile') }}" method="post">
                        @csrf
                        <h5 class="mb-4 text-uppercase"><i
                                class="mdi mdi-account-circle me-1"></i> {{ __('seller::seller.personal_info') }}</h5>
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
                                    <label for="name" class="form-label">{{ __('seller::seller.name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                           value="{{ old('name',Auth::user()->name) }}" autofocus tabindex="1"
                                           placeholder="{{ __('seller::seller.name_placeholder') }}">
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text"
                                          id="basic-addon3">{{ config('seller.profile_prefix')  }}</span>
                                    <input type="text" class="form-control" id="slug" name="slug" required
                                           @if(Auth::user()->slug) readonly @endif
                                           value="{{ old('slug',Auth::user()->slug) }}" tabindex="2">
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="bio" class="form-label">{{ __('seller::seller.bio') }}</label>
                                    <textarea class="form-control" id="bio" rows="4" name="bio" tabindex="3"
                                              placeholder="{{ __('seller::seller.bio_placeholder') }}">{{ old('bio',Auth::user()->bio) }}</textarea>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <h5 class="mb-3 text-uppercase bg-light p-2"><i
                                class="mdi mdi-office-building me-1"></i>{{ __('seller::seller.company_info') }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="company_name"
                                           class="form-label">{{ __('seller::seller.company_name') }}</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name"
                                           tabindex="4" value="{{ old('website',Auth::user()->company_name) }}"
                                           placeholder="{{ __('seller::seller.company_name_placeholder') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="website" class="form-label">{{ __('seller::seller.website') }}</label>
                                    <input type="url" class="form-control" id="website" name="website" tabindex="5"
                                           value="{{ old('website',Auth::user()->website) }}"
                                           placeholder="{{ __('seller::seller.website_placeholder') }}">
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2" tabindex="6"><i
                                    class="mdi mdi-content-save"></i> {{ __('seller::seller.save') }}
                            </button>
                        </div>
                    </form>
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
@endsection
