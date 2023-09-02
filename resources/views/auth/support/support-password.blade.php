@production
    @php
        $__defaults = [
            'email'    => old('email'),
            'password' => old('password')
        ];
    @endphp
@else
    @php
        $__defaults = [
            'email'    => App\Models\Roles\SuperAdmin::first()->user->email,
            'password' => 'password'
        ];
    @endphp
@endproduction
@extends('layouts.app')

@section('content')
    <div class="nk-content">
        <div class="nk-split nk-split-page nk-split-md">
            <div class="bg-white nk-split-content nk-block-area nk-block-area-column nk-auth-container">
                <div class="p-3 absolute-top-right d-lg-none p-sm-5">
                    <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo">
                        <em class="icon ni ni-info"></em>
                    </a>
                </div>

                <div class="nk-block nk-block-middle nk-auth-body">
                    <x-layout.auth-logo />

                    {{-- Title and tagline wrapper --}}
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h5 class="nk-block-title">Support Functionality</h5>
                            <div class="nk-block-des">
                                <p>Access the Cogni™ Support Panel using Support password</p>
                            </div>
                        </div>
                    </div>

                    {{-- Authentication form --}}
                    <form method="POST" action="{{ route('super_admin.dashboard.support.password') }}" id="loginForm" class="form-validate is-alter">
                        @csrf

                        {{-- Password --}}
                        <div class="form-group">
                            {{-- Input label --}}
                            <div class="form-label-group">
                                <label class="form-label" for="password">Password</label>
                                <a class="link link-primary link-sm" tabindex="-1" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            </div>

                            {{-- Input field --}}
                            <div class="form-control-wrap">
                                <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg"
                                    data-target="password">
                                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                </a>
                                <input
                                    id="password"
                                    type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Enter your password"
                                >
                            </div>

                            {{-- Error response --}}
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>



                        {{-- Submit button --}}
                        <div class="form-group">
                            <button class="btn btn-lg btn-primary btn-block">Sign in</button>
                        </div>
                    </form>

                    {{-- Registration link --}}
                    {{-- <div class="pt-4 form-note-s2">
                        New on our platform?
                        <a href="{{ route('register') }}">Create an account</a>
                    </div> --}}
                </div>

                {{-- Footer --}}
                <x-layout.auth-footer />
            </div>

            {{-- Sideview (promo content) --}}
            <div class="flex-col login-bg-content nk-split-content d-flex nk-split-stretch toggle-break-lg toggle-slide toggle-slide-right" data-content="athPromo" data-toggle-screen="lg"
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
    </div>
@endsection
