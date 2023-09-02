<li class="nk-menu-item">
    <a href="{{ route('client.dashboard') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-home-alt"></em></span>
        <span class="nk-menu-text">Client Dashboard</span>
    </a>
</li>
<li class="nk-menu-item">
    <a href="#" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-book"></em></span>
        <span class="nk-menu-text">User Guide</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('client.dashboard.packages') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-bag"></em></span>
        <span class="nk-menu-text">Packages</span>
    </a>
</li>


<li class="nk-menu-heading">
    <h6 class="overline-title text-primary-alt">Cogni™ Features</h6>
</li>

@can('access-bookings')
    <li class="nk-menu-item has-sub">
        <a href="#" class="nk-menu-link nk-menu-toggle">
            <span class="nk-menu-icon"><em class="icon ni ni-calender-date"></em></span>
            <span class="nk-menu-text">Bookings</span>
        </a>
        <ul class="nk-menu-sub">
            <li class="nk-menu-item">
                <a href="{{ route('client.dashboard.appointments') }}" class="nk-menu-link">
                    <span class="nk-menu-text">Providers</span>
                </a>
            </li>
        </ul>
    </li>
@endcan

@can('access-therapies')
    <li class="nk-menu-item">
        <a href="{{ route('client.dashboard.client_to_do') }}" class="nk-menu-link">
            <span class="nk-menu-icon">
                <em class="icon ni ni-calender-date"></em>
            </span>
            <span class="nk-menu-text">Self-Guided Therapy</span>
        </a>
    </li>
@endcan

<li class="nk-menu-item">
    <a href="{{ route('dashboard.collective-support') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-info"></em></span>
        <span class="nk-menu-text">About Cogni&trade; Collective Support</span>
    </a>
</li>
<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle">
        <span class="nk-menu-icon"><em class="icon ni ni-note-add"></em></span>
        <span class="nk-menu-text">My Progress</span>
    </a>
    <ul class="nk-menu-sub">
        <li class="nk-menu-item">
            <a href="{{ route('dashboard.archives') }}" class="nk-menu-link"><span
                    class="nk-menu-text">My Data</span></a>
        </li>

        <li class="nk-menu-item">
            <a href="#" class="nk-menu-link">
                <span class="nk-menu-text">My Tools</span>
            </a>
        </li>
    </ul><!-- .nk-menu-sub -->
</li>
<li class="nk-menu-item">
    <a href="{{ route('client.dashboard.payments') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-coins"></em></span>
        <span class="nk-menu-text">Accounting</span>
    </a>
</li>

@can('access-chatting')
    <li class="nk-menu-item">
        <a href="{{ route('dashboard.chat') }}" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-chat-circle"></em></span>
            <span class="nk-menu-text">Messaging</span>
        </a>
    </li>
@endcan
