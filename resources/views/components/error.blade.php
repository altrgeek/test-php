@props(['code' => 500, 'title' => null])
<x-app no-navbar no-sidebar bare-content no-footer :title="$title">
    <div class="nk-block nk-block-middle wide-xs mx-auto">
        <div class="nk-block-content nk-error-ld text-center">
            <h1 class="nk-error-head">{{ $code }}</h1>
            <h3 class="nk-error-title">{{ $title }}</h3>
            <p class="nk-error-text">
                {{ $slot }}
            </p>
            <a href="{{ url('/') }}" class="btn btn-lg btn-primary mt-2">Back To Home</a>
        </div>
    </div>
</x-app>
