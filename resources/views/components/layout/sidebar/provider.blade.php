<li class="nk-menu-item">
    <a href="{{ route('provider.dashboard') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-home-alt"></em></span>
        <span class="nk-menu-text">Service Providers Dashboard</span>
    </a>
</li>
<li class="nk-menu-item">
    <a href="#" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-book"></em></span>
        <span class="nk-menu-text">User Guide</span>
    </a>
</li>


<li class="nk-menu-heading">
    <h6 class="overline-title text-primary-alt">Client Management</h6>
</li>
<li class="nk-menu-item">
    <a href="{{ route('provider.dashboard.clients') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
        <span class="nk-menu-text">Manage Clients</span>
    </a>
</li>

<li class="nk-menu-heading">
    <h6 class="overline-title text-primary-alt">Cogni™ Features</h6>
</li>
<li class="nk-menu-item">
    <a href="{{ route('provider.todo_calendar') }}" class="nk-menu-link">
        <span class="nk-menu-icon">
            <em class="icon ni ni-bar-chart"></em>
        </span>
        <span class="nk-menu-text">ToDo List</span>
    </a>
</li>
@can('access-bookings')
    <li class="nk-menu-item has-sub">
        <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
            <span class="nk-menu-icon"><em class="icon ni ni-calender-date"></em></span>
            <span class="nk-menu-text">Bookings</span>
        </a>
        <ul class="nk-menu-sub">
            <li class="nk-menu-item">
                <a href="{{ route('provider.dashboard.appointments.admin') }}" class="nk-menu-link">
                    <span class="nk-menu-text">Admins</span>
                </a>
            </li>
            <li class="nk-menu-item">
                <a href="{{ route('provider.dashboard.appointments.client') }}" class="nk-menu-link">
                    <span class="nk-menu-text">Clients</span>
                </a>
            </li>
        </ul>
    </li>
@endcan

<li class="nk-menu-item">
    <a href="{{ route('dashboard.analytics') }}" class="nk-menu-link">
        <span class="nk-menu-icon">
            <em class="icon ni ni-bar-chart"></em>
        </span>
        <span class="nk-menu-text">Analytics</span>
    </a>
</li>

@can('access-therapies')
    <li class="nk-menu-item has-sub">
        <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
            <span class="nk-menu-icon"><i class="fas fa-vr-cardboard"></i></span>
            <span class="nk-menu-text">Cogni® Virtual Solutions</span>
        </a>
        <ul class="nk-menu-sub">
            <li class="nk-menu-item">
                <a href="{{ route('dashboard.wellness-program') }}" class="nk-menu-link" data-original-title="" title="">
                    <span class="nk-menu-text">Cogni® Wellness Program</span>
                </a>
            </li>
            <li class="nk-menu-item">
                <a href="{{ route('dashboard.vr-therapies') }}" class="nk-menu-link" data-original-title="" title="">
                    <span class="nk-menu-text">Self-guided & training </span>
                </a>
            </li>
            <li class="nk-menu-item">
                <a href="{{ route('dashboard.vr-therapies-groups') }}" class="nk-menu-link" data-original-title="" title="">
                    <span class="nk-menu-text">Group support </span>
                </a>
            </li>
        </ul>
    </li>
@endcan

<li class="nk-menu-item">
    <a href="{{ route('dashboard.collective-support') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-info"></em></span>
        <span class="nk-menu-text">About Cogni&trade; Progress Notes</span>
    </a>
</li>
<li class="nk-menu-item">
    <a href="{{ route('provider.dashboard.archives') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-package"></em></span>
        <span class="nk-menu-text">Archives</span>
    </a>
</li>
<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
        <span class="nk-menu-icon" style="font-size: 20px;">
            <i class="fas fa-toolbox"></i>
        </span>
        <span class="nk-menu-text">Tool Box</span>
    </a>
    <ul class="nk-menu-sub">
        <li class="nk-menu-item">
            <a href="user_list.html" class="nk-menu-link" data-original-title="" title=""><span
                    class="nk-menu-text">AI speech to text</span></a>
        </li>
        <li class="nk-menu-item">
            <a href="user_list.html" class="nk-menu-link" data-original-title="" title=""><span
                    class="nk-menu-text">AI Emotion</span></a>
        </li>
    </ul><!-- .nk-menu-sub -->
</li>
<li class="nk-menu-item">
    <a href="{{ route('provider.dashboard.payments') }}" class="nk-menu-link">
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
