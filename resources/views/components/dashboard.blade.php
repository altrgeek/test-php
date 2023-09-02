@props([
    'title' => null,
    'description' => null,
    'noMargin' => false
])
<x-app {{ $attributes }}>
    {{-- Alert responses --}}
    <x-layout.alert />

    {{-- Header --}}
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between @unless($noMargin) pt-5 mt-3 @endunless">
            <div class="nk-block-head-content">
                {{-- Title --}}
                @if (CStr::isValidString($title))
                    <h3 class="nk-block-title page-title">{!! $title !!}</h3>
                @endif
                {{-- Description --}}
                @if (CStr::isValidString($desription))
                    <div class="nk-block-des text-soft">
                        <p>{!! $description !!}</p>
                    </div>
                @endif
            </div>
            @isset($addBtn)
                <div class="nk-block-head-content">{{ $addBtn }}</div>
            @endisset
            @isset($header)
                <div class="nk-block-head-content">
                    {{ $header ?? null }}
                </div>
            @endisset
        </div>
    </div>

    <div class="nk-block">{{ $slot }}</div>

    <x-slot name="scripts">
        {{ $scripts ?? null }}
        @vite(['resources/ts/main.ts', 'resources/ts/index.tsx'])
    </x-slot>
    <x-slot name="styles">{{ $styles ?? null }}</x-slot>
    <x-slot name="modals">{{ $modals ?? null }}</x-slot>
    <x-slot name="content">{{ $content ?? null }}</x-slot>
    <x-slot name="popups">{{ $popups ?? null }}</x-slot>

</x-app>
