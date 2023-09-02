@php
    $__session_config['user']['avatar'] = optional($__session_config['user']['avatar'], fn ($avatar) => asset($avatar));
    $__session_config['session']['guest']['avatar'] = optional($__session_config['session']['guest']['avatar'], fn ($avatar) => asset($avatar));
@endphp
<x-skeleton title="{{ $session_name ?? null }}">
    <x-slot name="styles">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;700&display=swap" rel="stylesheet" />
        <link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet" />
        @vite(['resources/css/tailwind.css'])
    </x-slot>

    <div id="meetings_module"></div>

    <x-slot name="scripts">
        <script type="text/javascript">
            window.VITE_PUSHER_APP_KEY = "{!! config('broadcasting.connections.pusher.key') !!}";
            window.VITE_PUSHER_HOST = "{!! config('broadcasting.connections.pusher.options.client.host') !!}";
            window.VITE_PUSHER_PORT = {!! config('broadcasting.connections.pusher.options.client.port') !!};
            window.VITE_PUSHER_SCHEME = "{!! config('broadcasting.connections.pusher.options.client.scheme') !!}";
            window.VITE_APP_URL = "{!! config('app.url') !!}";

            Object.assign(window.__cogni, {!! json_encode($__session_config) !!});
        </script>

        @vite(['resources/ts/main.ts', 'resources/ts/index.tsx'])
    </x-slot>
</x-skeleton>
