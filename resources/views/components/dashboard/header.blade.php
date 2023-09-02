@props(['title'])
<div class="nk-block">
    <div class="nk-block-between">
        {{-- Page title --}}
        <div class="nk-block-head-content">
            @if (CStr::isValidString($title))
                <h3 class="nk-block-title page-title">Admins Management</h3>
            @endif
        </div>

        <div class="nk-block-head-content">
            {{ $slot ?? '' }}
        </div>
    </div>
</div>
