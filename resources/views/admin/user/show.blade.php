@extends('admin::layouts.panel')

@section('title',__('seller::seller.seller_information'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('seller::seller.seller_information') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('seller::seller.seller_information') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('seller::seller.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                       value="{{ $seller->name }}" readonly autofocus tabindex="1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="slug" class="form-label">{{ __('seller::seller.slug') }}</label>
                                <input type="text" class="form-control" id="slug" name="slug" required
                                       value="{{ $seller->slug }}" readonly autofocus tabindex="2">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="country" class="form-label">{{ __('seller::seller.country') }}</label>
                                <input type="text" class="form-control" id="country_id" name="country" required
                                       value="{{ $seller->country->name }}" readonly autofocus tabindex="3">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('seller::seller.email') }}</label>
                                <input type="text" class="form-control" id="email" name="email" required
                                       value="{{ $seller->email }}" readonly autofocus tabindex="4">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="company_name"
                                       class="form-label">{{ __('seller::seller.company_name') }}</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" required
                                       value="{{ $seller->company_name }}" readonly autofocus tabindex="5">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="website" class="form-label">{{ __('seller::seller.website') }}</label>
                                <input type="text" class="form-control" id="website" name="website" required
                                       value="{{ $seller->website }}" readonly autofocus tabindex="6">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="source" class="form-label">{{ __('seller::seller.source') }}</label>
                                <input type="text" class="form-control" id="source" name="source" required
                                       value="{{ $seller->source }}" readonly autofocus tabindex="7">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="bio" class="form-label">{{ __('seller::seller.bio') }}</label>
                                <textarea class="form-control" id="bio" rows="4" name="bio" tabindex="8"
                                          readonly>{{ old('bio',Auth::user()->bio) }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="status_box" name="status"
                                           tabindex="9"
                                           value="1" {{ $seller->status?'checked':'' }}>
                                    <label for="status_box"
                                           class="form-check-label">{{ __('seller::seller.active') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
