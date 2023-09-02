<div class="nk-sidebar-element nk-sidebar-head">
    <div class="nk-menu-trigger">
        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em
                class="icon ni ni-arrow-left"></em></a>
        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em
                class="icon ni ni-menu"></em></a>
    </div>
    @php

    if(auth()->user())
     $user = auth()->user();
      @endphp
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
             {{-- Logo wrapper --}}
             <div class="nk-sidebar-brand">
                <a href="{{ route('super_admin.dashboard') }}" class="logo-link nk-sidebar-logo">
                    <img class="logo-light logo-img" src="{{ $__admin['admin']->admin->logo }}"
                        srcset="{{ $__admin['admin']->admin->logo }} 2x" alt="logo">
                    <img class="logo-dark logo-img" src="{{ $__admin['admin']->admin->logo }}"
                        srcset="{{ $__admin['admin']->admin->logo }} 2x" alt="logo-dark">
                </a>
            </div>
        @else
             {{-- Logo wrapper --}}
             <div class="nk-sidebar-brand">
                <a href="{{ route('super_admin.dashboard') }}" class="logo-link nk-sidebar-logo">
                    <img class="logo-light logo-img" src="{{ asset('images/cogni_logo_reg.png') }}"
                        srcset="{{ asset('images/cogni_logo_reg.png') }} 2x" alt="logo">
                    <img class="logo-dark logo-img" src="{{ asset('images/cogni_logo_reg.png') }}"
                        srcset="{{ asset('images/cogni_logo_reg.png') }} 2x" alt="logo-dark">
                </a>
            </div>
        @endif
    
</div><!-- .nk-sidebar-element -->
