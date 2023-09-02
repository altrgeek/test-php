<x-app>
    <x-slot name="styles">
        @yield('styles')
    </x-slot>

    @yield('content')

    <x-slot name="scripts">
        @yield('scripts')
    </x-slot>
</x-app>
