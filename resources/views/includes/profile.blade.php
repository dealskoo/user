<div class="card text-center">
    <div class="card-body">
        <div class="avatar-box">
            <img src="{{ Auth::user()->avatar_url }}" class="rounded-circle avatar-lg img-thumbnail avatar-pic"
                 alt="profile-image">
            <div class="upload-image">
                <i class="mdi mdi-camera upload-button"></i>
                <input class="file-upload" type="file" accept="image/*"
                       data-action="{{ route('seller.account.avatar') }}"/>
            </div>
        </div>

        <h4 class="mb-0 mt-2">{{ Auth::user()->name }}</h4>
        <p class="text-muted font-14">{!! Auth::user()->status?'<span class="badge bg-success">'.__('seller::seller.active').'</span>':'<span class="badge bg-danger">'.__('seller::seller.inactive').'</span>' !!}</p>

        <div class="text-start mt-3">
            @isset(Auth::user()->bio)
                <h4 class="font-13 text-uppercase">{{ __('seller::seller.about_me') }} :</h4>
                <p class="text-muted font-13 mb-3">
                    {{ Auth::user()->bio }}
                </p>
            @endisset
            <p class="text-muted mb-1 font-13"><strong>{{ __('seller::seller.name') }} :</strong> <span
                    class="ms-2">{{ Auth::user()->name }}</span></p>
            <p class="text-muted mb-1 font-13"><strong>{{ __('seller::seller.target_market') }} :</strong> <span
                    class="ms-2">{{ Auth::user()->country->name }}</span></p>
            <p class="text-muted mb-1 font-13"><strong>{{ __('seller::seller.email') }} :</strong> <span
                    class="ms-2 ">{{ Auth::user()->email }}</span>
            </p>
            <p class="text-muted mb-1 font-13"><strong>{{ __('seller::seller.company_name') }} :</strong> <span
                    class="ms-2">{{ Auth::user()->company_name }}</span>
            </p>
            <p class="text-muted mb-1 font-13"><strong>{{ __('seller::seller.website') }} :</strong> <span
                    class="ms-2">{{ Auth::user()->website }}</span>
            </p>
        </div>
    </div> <!-- end card-body -->
</div> <!-- end card -->
