@extends('admin::layouts.panel')

@section('title',__('user::user.edit_user'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('user::user.edit_user') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('user::user.edit_user') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.update',$user) }}" method="post">
                        @csrf
                        @method('PUT')
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
                                    <label for="name" class="form-label">{{ __('user::user.name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                           value="{{ $user->name }}" readonly autofocus tabindex="1">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">{{ __('user::user.slug') }}</label>
                                    <input type="text" class="form-control" id="slug" name="slug" required
                                           value="{{ $user->slug }}" readonly autofocus tabindex="2">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="country" class="form-label">{{ __('user::user.country') }}</label>
                                    <input type="text" class="form-control" id="country_id" name="country" required
                                           value="{{ $user->country->name }}" readonly autofocus tabindex="3">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('user::user.email') }}</label>
                                    <input type="text" class="form-control" id="email" name="email" required
                                           value="{{ $user->email }}" readonly autofocus tabindex="4">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="company_name"
                                           class="form-label">{{ __('user::user.company_name') }}</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" required
                                           value="{{ $user->company_name }}" readonly autofocus tabindex="5">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="website" class="form-label">{{ __('user::user.website') }}</label>
                                    <input type="text" class="form-control" id="website" name="website" required
                                           value="{{ $user->website }}" readonly autofocus tabindex="6">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="source" class="form-label">{{ __('user::user.source') }}</label>
                                    <input type="text" class="form-control" id="source" name="source" required
                                           value="{{ $user->source }}" readonly autofocus tabindex="7">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="bio" class="form-label">{{ __('user::user.bio') }}</label>
                                    <textarea class="form-control" id="bio" rows="4" name="bio" tabindex="8"
                                              readonly>{{ old('bio',Auth::user()->bio) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="status_box" name="status"
                                               tabindex="9"
                                               value="1" {{ $user->status?'checked':'' }}>
                                        <label for="status_box"
                                               class="form-check-label">{{ __('user::user.active') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2" tabindex="5"><i
                                    class="mdi mdi-content-save"></i> {{ __('admin::admin.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
