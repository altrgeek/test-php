@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <x-layout.auth-footer />
            </div>

            {{-- Sideview (promo content) --}}
            <div class="nk-split-content nk-split-stretch  d-flex toggle-break-lg toggle-slide toggle-slide-right"
                style="background-image: url('{{ asset('images/cogni-ui-background/Group 3285.png') }}'); background-size: cover;" data-content="athPromo" data-toggle-screen="lg"
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
</div>
@endsection
