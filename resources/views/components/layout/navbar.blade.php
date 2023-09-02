<div class="nk-header nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            {{-- Sidebar toggler --}}
            <div class="nk-menu-trigger d-xl-none ml-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu">
                    <em class="icon ni ni-menu"></em>
                </a>
            </div>

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
             <div class="nk-header-brand d-xl-none">
                <a href="{{ url('/') }}" class="logo-link">
                    <img class="logo-light logo-img" src="{{ $__admin['admin']->admin->logo }}" srcset="{{ $__admin['admin']->admin->logo }} 2x" alt="logo" />
                    <img class="logo-dark logo-img" src="{{ $__admin['admin']->admin->logo }}" srcset="{{ $__admin['admin']->admin->logo }} 2x" alt="logo-dark" />
                </a>
            </div>
        @else
             {{-- Logo wrapper --}}
             <div class="nk-header-brand d-xl-none">
                <a href="{{ url('/') }}" class="logo-link">
                    <img class="logo-light logo-img" src="{{ asset('images/cogni_logo_reg.png') }}" srcset="{{ asset('images/cogni_logo_reg.png') }} 2x" alt="logo" />
                    <img class="logo-dark logo-img" src="{{ asset('images/cogni_logo_reg.png') }}" srcset="{{ asset('images/cogni_logo_reg.png') }} 2x" alt="logo-dark" />
                </a>
            </div>
        @endif
           

            {{-- Header --}}
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    @php
                    $__languages = \Helpers\JSON::parseFile('languages.json');
                    $__user_lang = $__languages[request()->cookie('language') ?? 'en'];
                    $__get_flag = fn ($name) => asset(sprintf('images/flags/%s.png', strtolower($name)))
                    @endphp

                    {{-- Language selection dropdown --}}
                    <li class="dropdown language-dropdown d-block mr-n1 show">
                        <div class="dropdown-toggle nk-quick-nav-icon" data-toggle="dropdown" aria-expanded="true">
                            <div class="user-avatar xs border border-light">
                                <img src="{{ $__get_flag($__user_lang['flag']) }}" alt="{{ $__user_lang['name'] }}" />
                            </div>
                        </div>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-s1 " x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 38px, 0px);">
                            <ul class="language-list">
                                @foreach ($__languages as $__code => $__language)
                                <li>
                                    <a href="{{ route('language.update', ['lang' => $__code]) }}" class="language-item">
                                        <img src="{{ str_replace('-sq', '', $__get_flag($__language['flag'])) }}" class="language-flag" alt="{{ $__language['name'] }}" />
                                        <span class="language-name">{{ $__language['name'] }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>

                    <li class="dropdown notification-dropdown" id="notifications_module"></li>

                    {{-- User profile dropdown --}}
                    <li class="dropdown user-dropdown">

                        {{-- User overview --}}
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <span>
                                        <img src="{{ $user->avatar ? asset($user->avatar) : null }}">
                                    </span>
                                </div>
                                <div class="user-info d-none d-md-block">
                                    <div class="user-name dropdown-indicator">{{ $user->name }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Settings dropdown --}}
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1">

                            {{-- Profile details --}}
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        <span>
                                            <img src="{{ $user->avatar ? asset($user->avatar) : null }}">
                                        </span>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">{{ $user->name }}</span>
                                        <span class="sub-text">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Profile Management --}}
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    @role('admin')<li>
                                        <a href="{{ route('admin.profile') }}">
                                            <em class="icon ni ni-user-alt"></em>
                                            <span>View Profile</span>
                                        </a>
                                    </li>
                                @endrole
                                @role('provider' )
                                    {{-- Profile settings --}}
                                    <li>
                                        <a href="{{ route('dashboard.profile') }}">
                                            <em class="icon ni ni-user-alt"></em>
                                            <span>View Profile</span>
                                        </a>
                                    </li>
            @endrole

                      @role('super_admin')
                                    {{-- Profile settings --}}
                                    <li>
                                        <a href="{{ route('dashboard.profile') }}">
                                            <em class="icon ni ni-user-alt"></em>
                                            <span>View Profile</span>
                                        </a>
                                    </li>
            @endrole
                      @role('client')
                                    {{-- Profile settings --}}
                                    <li>
                                        <a href="{{ route('dashboard.profile') }}">
                                            <em class="icon ni ni-user-alt"></em>
                                            <span>View Profile</span>
                                        </a>
                                    </li>
            @endrole
                                    {{-- Dark mode toggler --}}
                                    <li>
                                        <a class="dark-switch" href="#">
                                            <em class="icon ni ni-moon"></em>
                                            <span>Dark Mode</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            {{-- Logout --}}
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <form id="logout_form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <li>
                                        <a href="#" id="logout_btn">
                                            <em class="icon ni ni-signout"></em>
                                            <span>Sign out</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', function () {
        $('#logout_btn').on('click', function (event) {
            event.preventDefault();
            $('#logout_form').submit();
        })
    });
</script>
