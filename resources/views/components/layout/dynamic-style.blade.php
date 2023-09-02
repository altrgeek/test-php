@if ($user->getRoleNames()[0] === 'provider' || $user->getRoleNames()[0] === 'client')
    @if ($user->getRoleNames()[0] === 'provider')
        @php
            $__admin = [
                'admin' => App\Models\Roles\Provider::where('user_id', $user->id)
                    ->with('admin')
                    ->first(),
            ];
        @endphp
    @elseif($user->getRoleNames()[0] === 'client')
        @php
            $__admin = [
                'role' => App\Models\Roles\Client::where('user_id', $user->id)
                    ->with('provider')
                    ->first(),
            ];
        @endphp
        @php
            $__admin = [
                'admin' => App\Models\Roles\Provider::where('id', $__admin['role']->id)
                    ->with('admin')
                    ->first(),
            ];
        @endphp
    @endif
    <style>
        /* Pimary color */
        .nk-menu-link:hover .nk-menu-icon,
        .nk-menu-item.active>.nk-menu-link .nk-menu-icon,
        .nk-menu-item.current-menu>.nk-menu-link .nk-menu-icon {
            color: {{ $__admin['admin']->admin->primary_color }} !important;
        }

        .nk-menu-link:hover,
        .active>.nk-menu-link {
            color: {{ $__admin['admin']->admin->primary_color }} !important;
        }

        .link-list a:hover {
            color: {{ $__admin['admin']->admin->primary_color }} !important;
        }

        .user-avatar,
        [class^="user-avatar"]:not([class*="-group"]) {
            background: {{ $__admin['admin']->admin->primary_color }} !important;
        }

        .link-list-opt a:hover {
            background: {{ $__admin['admin']->admin->secondary_color }} !important;
            color: {{ $__admin['admin']->admin->text_color }} !important;
        }

        body>div.nk-app-root>div>div.nk-wrap>div.nk-content>div>div>div>div.nk-block>div.row.g-gs>div>div>div>div>div>div.float-right>em {
            color: {{ $__admin['admin']->admin->primary_color }} !important;
        }

        .btn-dim.btn-outline-light:not(:disabled):not(.disabled):hover,
        .dt-buttons .btn-dim.btn-secondary:not(:disabled):not(.disabled):hover {
            color: {{ $__admin['admin']->admin->text_color }} !important;
            background-color: {{ $__admin['admin']->admin->secondary_color }} !important;
            border-color: {{ $__admin['admin']->admin->secondary_color }} !important;
        }

        .text-primary {
            color: {{ $__admin['admin']->admin->primary_color }} !important;

        }

        .dark-switch.active:before {
            background-color: {{ $__admin['admin']->admin->primary_color }} !important;
            border-color: {{ $__admin['admin']->admin->primary_color }} !important;
        }

        .dark-mode .ql-picker.ql-expanded .ql-picker-label,
        .dark-mode .active>.nk-menu-link,
        .dark-mode .is-theme .nk-menu-link:hover .nk-menu-icon,
        .dark-mode .is-theme .nk-menu-item.active>.nk-menu-link .nk-menu-icon,
        .dark-mode .is-theme .nk-menu-item.current-menu>.nk-menu-link .nk-menu-icon,
        .dark-mode .is-theme .nk-menu-sub .nk-menu-link:hover,
        .dark-mode .is-theme .nk-menu-sub .active>.nk-menu-link,
        .dark-mode .page-link:hover {
            color: {{ $__admin['admin']->admin->primary_color }} !important;
        }

        /* Secondory color */
        .nk-sidebar.is-dark {
            background-color: {{ $__admin['admin']->admin->secondary_color }} !important;

        }

        .brading-preview {
            background-color: {{ $__admin['admin']->admin->secondary_color }} !important;
        }

        a.text-primary:hover,
        a.text-primary:focus {
            background-color: {{ $__admin['admin']->admin->secondary_color }} !important;
        }

        /* text color */

        .nk-menu-link,
        .nk-menu-icon {
            color: {{ $__admin['admin']->admin->text_color }} !important;
        }
    </style>
@endif
@if ($user->getRoleNames()[0] === 'admin')
    @php
        $__admin = [
            'admin' => App\Models\Roles\Admin::where('user_id', $user->id)->first(),
        ];
    @endphp

    <style>
        .dynamic-link:hover,
        .active>.dynamic-link {
            color: {{ $__admin['admin']->primary_color }} !important;
        }
        .dynamic-link:hover .nk-menu-icon,
        .nk-menu-item.active>.dynamic-link .nk-menu-icon,
        .nk-menu-item.current-menu>.dynamic-link .nk-menu-icon {
            color: {{ $__admin['admin']->primary_color }} !important;
        }
        
    </style>
@endif
