@extends('layouts.app')

@section('content')

<div class="nk-content ">
    <div class="nk-split nk-split-page nk-split-md">
        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
            <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
            </div>
            <div class="nk-block nk-block-middle nk-auth-body">
                <x-layout.auth-logo />

                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Sign-In</h5>
                        <div class="nk-block-des">
                            <p>Access the Cogni™ User Panel using your email and password</p>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                <form  method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="name">Name</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your name">
                        </div>
                        @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email </label>
                        <div class="form-control-wrap">
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" is-invalid  name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email address">
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="form-control-wrap">
                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" class="form-control form-control-lg  @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password" placeholder="Enter your password">
                        </div>
                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password-confirm">Confirm Password</label>
                        <div class="form-control-wrap">
                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password-confirm">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" class="form-control form-control-lg " id="password-confirm" name="password_confirmation" required autocomplete="new-password" placeholder="Enter your password">
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-control-xs custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkbox" required>
                            <label class="custom-control-label" for="checkbox">I agree to Cogni&trade; <a tabindex="-1" href="#">Privacy Policy</a> &amp; <a tabindex="-1" href="#"> Terms.</a></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block">Register</button>
                    </div>
                </form>
            </div><!-- .nk-block -->
            <x-layout.auth-footer />
        </div><!-- .nk-split-content -->
        <div class="nk-split-content nk-split-stretch  d-flex toggle-break-lg toggle-slide toggle-slide-right" style="background-color: #253668;" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
            <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
                <div class="nk-feature-content py-4 p-sm-5  ">
                    <h2 class="text-center" style="color: #5CD0B0">Cogni™ XR Health</h2>
                    <p class="text-center mt-3" style="font-size:15px; color:white">Welcome to the Health Portal, a space where Health Care Providers meet their clients safely for remote and in-person therapy by leveraging virtual and augmented reality, and controlling their database.</p>
                </div>
                {{-- <div class="slider-init" data-slick='{"dots":true, "arrows":false}'>
                    <div class="slider-item">
                        <div class="nk-feature nk-feature-center">
                            <div class="nk-feature-img">
                                <img class="round" src="{{asset('images/slides/promo-a.png')}}" srcset="{{asset('images/slides/promo-a2x.png')}} 2x" alt="">
                            </div>
                            <div class="nk-feature-content py-4 p-sm-5">
                                <h4>Cogni™</h4>
                                <p>Explore The new feature of Cogni™ and take you health care easy and at home with the help of our advance Tech solution.</p>
                            </div>
                        </div>
                    </div><!-- .slider-item -->
                    <div class="slider-item">
                        <div class="nk-feature nk-feature-center">
                            <div class="nk-feature-img">
                                <img class="round" src="{{asset('images/slides/promo-b.png')}}" srcset="{{asset('images/slides/promo-b2x.png')}} 2x" alt="">
                            </div>
                            <div class="nk-feature-content py-4 p-sm-5">
                                <h4>Cogni™</h4>
                                <p>Explore The new feature of Cogni™ and take you health care easy and at home with the help of our advance Tech solution.</p>
                            </div>
                        </div>
                    </div><!-- .slider-item -->
                    <div class="slider-item">
                        <div class="nk-feature nk-feature-center">
                            <div class="nk-feature-img">
                                <img class="round" src="{{asset('images/slides/promo-c.png')}}" srcset="{{asset('images/slides/promo-c2x.png')}} 2x" alt="">
                            </div>
                            <div class="nk-feature-content py-4 p-sm-5">
                                <h4>Cogni™</h4>
                                <p>Explore The new feature of Cogni™ and take you health care easy and at home with the help of our advance Tech solution.</p>
                            </div>
                        </div>
                    </div><!-- .slider-item -->
                </div><!-- .slider-init --> --}}
                <div class="slider-dots"></div>
                <div class="slider-arrows"></div>
            </div><!-- .slider-wrap -->
        </div><!-- .nk-split-content -->
    </div><!-- .nk-split -->
</div>
@endsection
