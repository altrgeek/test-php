<!-- Dashboard -->
<li class="nk-menu-item">
    <a href="{{ route('super_admin.dashboard') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-property"></em></span>
        <span class="nk-menu-text">Super Admin Dashboard</span>
    </a>
</li>


<li class="nk-menu-heading">
    <h6 class="overline-title text-primary-alt">User Management</h6>
</li>
<!-- User guide (static) -->
<li class="nk-menu-item">
    <a href="#" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
        <span class="nk-menu-text">User Guide</span>
    </a>
</li>
<!-- New requests (CRUD) -->
<li class="nk-menu-item">
    <a href="#" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
        <span class="nk-menu-text">New Clients Request</span>
    </a>
</li>
<!-- Subscriptions (CRUD) -->
<li class="nk-menu-item">
    <a href="{{ route('super_admin.dashboard.subscriptions') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
        <span class="nk-menu-text">Add Subscriptions</span>
    </a>
</li>
<!-- Admin accounts (CRUD) -->
<li class="nk-menu-item">
    <a href="{{ route('super_admin.dashboard.admins') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
        <span class="nk-menu-text">Admins Management</span>
    </a>
</li>
<!-- Users management (CRUD) -->
<li class="nk-menu-item">
    <a href="{{ route('super_admin.dashboard.users') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
        <span class="nk-menu-text">User Management</span>
    </a>
</li>
<!-- Registered clients details (read-only) -->
<li class="nk-menu-item">
    <a href="{{ route('super_admin.dashboard.clients') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-user-list"></em></span>
        <span class="nk-menu-text">Clients</span>
    </a>
</li>

<li class="nk-menu-item">
    <a href="{{ route('dashboard.analytics') }}" class="nk-menu-link">
        <span class="nk-menu-icon">
            <em class="icon ni ni-bar-chart"></em>
        </span>
        <span class="nk-menu-text">Analytics</span>
    </a>
</li>

<li class="nk-menu-heading">
    <h6 class="overline-title text-primary-alt">Cogni™ Features</h6>
</li>
<li class="nk-menu-item">
    <a href="{{ route('dashboard.show-super-admin-todo-listing') }}" class="nk-menu-link" data-original-title="" title="">
        <span class="nk-menu-icon"><em class="icon ni ni-calender-date"></em></span>
        <span class="nk-menu-text">Assign Task to Admin</span>
    </a>
</li>
<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
        <span class="nk-menu-icon"><em class="icon ni ni-calender-date"></em></span>
        <span class="nk-menu-text">Bookings</span>
    </a>
    <ul class="nk-menu-sub">
        <li class="nk-menu-item">
            <a href="{{ route('super_admin.dashboard.appointments') }}" class="nk-menu-link">
                <span class="nk-menu-text">Admins</span>
            </a>
        </li>
    </ul>
</li>

{{-- <li class="nk-menu-item">
    <a href="{{ route('dashboard.vr-therapies') }}" class="nk-menu-link">
        <span class="nk-menu-icon">
            <em class="icon ni ni-calender-date"></em>
        </span>
        <span class="nk-menu-text">Treatment Plan Scenarios</span>
    </a>
</li> --}}
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
            <a href="{{ route('dashboard.vr-therapies') }}" class="nk-menu-link" data-original-title="" title="">
                <span class="nk-menu-text">Group support </span>
            </a>
        </li>
        
    </ul>
</li>
<li class="nk-menu-item">
    <a href="{{ route('dashboard.collective-support') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-monitor"></em></span>
        <span class="nk-menu-text">Create Cogni&trade; Progress Notes</span>
    </a>
</li>
<li class="nk-menu-item">
    <a href="{{ route('dashboard.archives') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><i class="fas fa-vr-cardboard"></i></span>
        <span class="nk-menu-text">Archives</span>
    </a>
</li>
<!-- Additional features -->
<li class="nk-menu-item has-sub">
    <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
        <span class="nk-menu-icon"><i class="fas fa-vr-cardboard"></i></span>
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
    </ul>
</li>
{{-- Stripe transactions history (read-only) --}}
<li class="nk-menu-item">
    <a href="{{ route('super_admin.dashboard.payments') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-monitor"></em></span>
        <span class="nk-menu-text">Accounting</span>
    </a>
</li>
<!-- Live chat -->
<li class="nk-menu-item">
    <a href="{{ route('dashboard.chat') }}" class="nk-menu-link">
        <span class="nk-menu-icon"><em class="icon ni ni-chat-circle"></em></span>
        <span class="nk-menu-text">Messaging</span>
    </a>
</li>
