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

                @include('layouts.alerts')
                <div class="nk-block-head">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Forget Password</h5>
                        <div class="nk-block-des">
                            <p>Access the Cogni™ User Panel using your email and password</p>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="default-01">Email</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="email" class="form-control form-control-lg  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Send Reset Link</button>
                    </div>
                </form>
            </div>
            <x-layout.auth-footer />
        </div><!-- .nk-block -->

        {{-- Sideview (promo content) --}}
        <div class="login-bg-content nk-split-content d-flex flex-col nk-split-stretch toggle-break-lg toggle-slide toggle-slide-right" data-content="athPromo" data-toggle-screen="lg"
            data-toggle-overlay="true">
            <div class="p-3 m-auto slider-wrap w-100 p-sm-5">
                <div class="pb-4 login-content nk-feature-content p-sm-5">
                    <div class="p-md-3"></div>
                    <img class="mt-2" width="250" height="auto" src="{{ asset('images/cogni_logo_reg.png') }}" alt="cogni-image">
                    <p class="text-center text-white mt-5" style="font-size:15px;">
                            Cogni® is expanding Wellness for All, Always 
                            Providing virtual solutions to accelerate wellness results so that Wellness Programs and Mental Health Providers support more people without delay.
                         </p>
                </div>
                <div class="sponsors d-flex justify-content-center">
                    <img height="30" src="{{ asset('images/cogni-new/Group 9.png') }}" alt="sponsor-1">
                </div>
            </div>
        </div>
    </div>
</div><!-- .nk-split -->
<!-- .nk-split-content -->
{{-- <div class="nk-split-content nk-split-stretch  d-flex toggle-break-lg toggle-slide toggle-slide-right" style="background-color: #253668;" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
    <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
        <div class="nk-feature-content py-4 p-sm-5  ">
            <h2 class="text-center" style="color: #5CD0B0">Cogni™ XR Health</h2>
            <p class="text-center mt-3" style="font-size:15px; color:white">Welcome to the Health Portal, a space where Health Care Providers meet their clients safely for remote and in-person therapy by leveraging virtual and augmented reality, and controlling their database.</p>
        </div>
        <div class="slider-init" data-slick='{"dots":true, "arrows":false}'>
            <div class="slider-item">
                <div class="nk-feature nk-feature-center">
                    <div class="nk-feature-img">
                        <img class="round" src="{{asset('images/slides/promo-a.png')}}" srcset="images/slides/promo-a2x.png 2x" alt="">
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
                        <img class="round" src="{{asset('images/slides/promo-b.png')}}" srcset="images/slides/promo-b2x.png 2x" alt="">
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
                        <img class="round" src="{{asset('images/slides/promo-c.png')}}" srcset="images/slides/promo-c2x.png 2x" alt="">
                    </div>
                    <div class="nk-feature-content py-4 p-sm-5">
                        <h4>Cogni™</h4>
                        <p>Explore The new feature of Cogni™ and take you health care easy and at home with the help of our advance Tech solution.</p>
                    </div>
                </div>
            </div><!-- .slider-item -->
        </div><!-- .slider-init -->
        <div class="slider-dots"></div>
        <div class="slider-arrows"></div>
    </div><!-- .slider-wrap -->
</div><!-- .nk-split-content --> --}}
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
