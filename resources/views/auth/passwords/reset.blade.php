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
                        <h5 class="nk-block-title">Reset Password</h5>
                        <div class="nk-block-des">
                            <p>Access the Cogni™ User Panel change your password</p>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="default-01">Email</label>
                        </div>
                        <div class="form-control-wrap">
                            <input id="email" type="email" class="form-control form-control-lg  @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="password">{{ __('Password') }}</label>
                        </div>
                        <div class="form-control-wrap">   <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="password">{{ __('Confirm Password') }}</label>
                        </div>
                        <div class="form-control-wrap">
                            <input id="password-confirm" type="password" class="form-control form-control-lg " name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Send Reset Link</button>
                    </div>
                </form>
            </div><!-- .nk-block -->
            <x-layout.auth-footer />
        </div><!-- .nk-split-content -->

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
    </div><!-- .nk-split -->
</div>
@endsection
