@props(['title' => null, 'noExpansion' => false])
@php
    $title =
        $title
            ? sprintf('%s%s', $title, !$noExpansion ? ' &mdash; Cogni&trade; Portal' : '')
            : 'Cogni&trade; XR Health Portal';
@endphp
<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="{{ config('app.description') }}" />
    <link rel="shortcut icon" href="{{ asset('images/cogni_logo_reg.png') }}" />
    <title>{!! $title !!}</title>
    {{ $head ?? null }}
    {{ $styles ?? null }}
</head>

<body {{ $attributes }}>
    <div id="root"></div>

    {{ $slot }}

    <script type="text/javascript">
        window.__cogni = typeof window.__cogni === "object" ? window.__cogni : {};
    </script>
    {{ $scripts ?? null }}
</body>
</html>
