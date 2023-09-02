<x-dashboard title="Client Dashboard">
    @if (Session::has('token'))
        <input type="hidden" id="getSessionToken" data-token="{{ Session::get('token') }}">
    @endif
</x-dashboard>
