@php
    $subscriptions = Auth::user()
        ->admin->subscription()
        ->count();

    if ($subscriptions > 0) {
        $subscription_id = Auth::user()->admin->subscription->subscriptions_id;
    }

    $subscriptions_id = App\Models\Subscriptions::pluck('id')->toArray();

    $subscriptions_expires_at = App\Models\Subscriptions::pluck('expires_at')->toArray();
@endphp

@if (
    (empty($subscriptions) && $subscriptions == null) ||
        ($subscriptions_id == $subscription_id && $subscriptions_expires_at <= now()))
    <li class="nk-menu-item">
        <a href="{{ route('admin.dashboard') }}" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-property"></em></span>
            <span class="nk-menu-text">Admin Dashboard</span>
        </a>
    </li>
    <li class="nk-menu-item">
        <a href="#" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
            <span class="nk-menu-text">User Guide</span>
        </a>
    </li>
    <li class="nk-menu-item">
        <a href="{{ route('admin.dashboard.subscriptions') }}" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
            <span class="nk-menu-text">Subscriptions</span>
        </a>
    </li>

    <li class="nk-menu-item">
        <a href="{{ route('admin.dashboard.packages') }}" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
            <span class="nk-menu-text">Add Packages</span>
        </a>
    </li>
@elseif (
    (!empty($subscriptions) && $subscriptions != null) ||
        ($subscriptions_id == $subscription_id && $subscriptions_expires_at >= now()))
    <li class="nk-menu-item">
        <a href="{{ route('admin.dashboard') }}" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-property"></em></span>
            <span class="nk-menu-text">Admin Dashboard</span>
        </a>
    </li>
    <li class="nk-menu-item">
        <a href="#" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
            <span class="nk-menu-text">User Guide</span>
        </a>
    </li>

    <li class="nk-menu-item">
        <a href="{{ route('admin.dashboard.subscriptions') }}" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
            <span class="nk-menu-text">Subscriptions</span>
        </a>
    </li>

    @can('manage-subscriptions')
        <li class="nk-menu-item">
            <a href="{{ route('admin.dashboard.packages') }}" class="nk-menu-link">
                <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
                <span class="nk-menu-text">Add Packages</span>
            </a>
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

    <li class="nk-menu-heading">
        <h6 class="overline-title text-primary-alt">User Management</h6>
    </li>
    <li class="nk-menu-item">
        <a href="{{ route('admin.dashboard.providers') }}" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
            <span class="nk-menu-text">Add Service Providers</span>
        </a>
    </li>
    <li class="nk-menu-item">
        <a href="#" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
            <span class="nk-menu-text">New Client Request</span>
        </a>
    </li>

    <li class="nk-menu-heading">
        <h6 class="overline-title text-primary-alt">Cogni™ Features</h6>
    </li>
    <li class="nk-menu-item">
        <a href="{{ route('admin.client-to-do-listing') }}" class="nk-menu-link" data-original-title="" title="">
            <span class="nk-menu-icon"><em class="icon ni ni-calender-date"></em></span>
            <span class="nk-menu-text">Assign Task to Provider</span>
        </a>
    </li>
    <li class="nk-menu-item">
        <a href="{{ route('admin.todo_calendar') }}" class="nk-menu-link" data-original-title="" title="">
            <span class="nk-menu-icon"><em class="icon ni ni-calender-date"></em></span>
            <span class="nk-menu-text">Todo List</span>
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
                    <a href="{{ route('admin.dashboard.appointments.super_admin') }}" class="nk-menu-link">
                        <span class="nk-menu-text">Super Admin</span>
                    </a>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('admin.dashboard.appointments.provider') }}" class="nk-menu-link">
                        <span class="nk-menu-text">Providers</span>
                    </a>
                </li>
            </ul>
        </li>
    @endcan

    @can('access-therapies')
        <li class="nk-menu-item has-sub">
            <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                <span class="nk-menu-icon"><i class="fas fa-vr-cardboard"></i></span>
                <span class="nk-menu-text">Cogni® Virtual Solutions</span>
            </a>
            <ul class="nk-menu-sub">
                <li class="nk-menu-item">
                    <a href="{{ route('dashboard.wellness-program') }}" class="nk-menu-link" data-original-title=""
                        title="">
                        <span class="nk-menu-text">Cogni® Wellness Program</span>
                    </a>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('dashboard.vr-therapies') }}" class="nk-menu-link" data-original-title=""
                        title="">
                        <span class="nk-menu-text">Self-guided & training </span>
                    </a>
                </li>
                <li class="nk-menu-item">
                    <a href="{{ route('dashboard.vr-therapies') }}" class="nk-menu-link" data-original-title="" title="">
                        <span class="nk-menu-text">Group support </span>
                    </a>
                </li>
            </ul>
        </li>
    @endcan

    <li class="nk-menu-item">
        <a href="{{ route('dashboard.collective-support') }}" class="nk-menu-link">
            <span class="nk-menu-icon"><em class="icon ni ni-monitor"></em></span>
            <span class="nk-menu-text">About Cogni&trade; Progress Notes</span>
        </a>
    </li>
    <li class="nk-menu-item">
        <a href="#" class="nk-menu-link">
            <span class="nk-menu-icon"><i class="fas fa-vr-cardboard"></i></span>
            <span class="nk-menu-text">Data Analysis</span>
        </a>
    </li>

    <li class="nk-menu-item">
        <a href="{{ route('dashboard.archives') }}" class="nk-menu-link">
            <span class="nk-menu-icon"><i class="fas fa-vr-cardboard"></i></span>
            <span class="nk-menu-text">Archives</span>
        </a>
    </li>

    <li class="nk-menu-item has-sub">
        <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
            <span class="nk-menu-icon"><i class="fas fa-vr-cardboard"></i></span>
            <span class="nk-menu-text">Toolbox</span>
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
        </ul>
    </li>
    <li class="nk-menu-item">
        <a href="{{ route('admin.dashboard.payments') }}" class="nk-menu-link">
            <span class="nk-menu-icon"><i class="fas fa-vr-cardboard"></i></span>
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
@endif
