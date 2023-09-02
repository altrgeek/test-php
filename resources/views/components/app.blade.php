@props([
    'noNavbar' => false,
    'noSidebar' => false,
    'noFooter' => false,
    'bareContent' => false,
    'title' => null
])
<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ config('app.description') }}">
    <meta name="stripe_pub_key" content="{{ env('STRIPE_PUBLIC_KEY') }}">
    <link rel="shortcut icon" href="{{ asset('images/cogni_logo_reg.png') }}">
    <title>{!! $title ?: 'Cogni&trade; Dashboard' !!}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=2.9.0') }}" />
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=2.9.0') }}" />
    <link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet" />
    {{ $styles ?? null }}
    <x-layout.dynamic-style />
</head>

<body class="nk-body bg-lighter npc-general has-sidebar">
    <div id="root"></div>
    <div class="nk-app-root">
        <div class="nk-main">
            @unless ($noSidebar)
                <x-layout.sidebar />
            @endunless
            <div class="nk-wrap">
                @unless ($noNavbar)
                    <x-layout.navbar />
                @endunless
                <div class="nk-content">
                    @if ($bareContent)
                        {{ $slot }}
                    @else
                        <div class="container-fluid">
                            <div class="nk-content-inner">
                                <div class="nk-content-body">
                                    {{ $slot }}
                                </div>
                            </div>
                        </div>
                        {{ $modals ?? null }}
                        {{ $content ?? null }}
                        {{ $popups ?? null }}
                    @endif
                </div>
                @unless ($noFooter)
                    <x-layout.footer />
                @endunless
            </div>
        </div>
    </div>
    <x-scripts/>
    {{ $scripts ?? null }}
</body>

</html>
