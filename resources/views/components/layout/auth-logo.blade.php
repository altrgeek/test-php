<div class="row pb-5">
    <!-- Site logo -->
    <div class="col-6 d-flex align-items-center">
 @if(auth()->user())
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
            <div class="brand-logo">
                <a href="/" class="logo-link">
                    <img class="logo-light logo-img logo-img-lg" src="{{ $__admin['admin']->admin->logo }}"
                        srcset="{{ $__admin['admin']->admin->logo  }} 2x" alt="logo" />
                    <img class="logo-dark logo-img logo-img-lg" src="{{ $__admin['admin']->admin->logo  }}"
                        srcset="{{ $__admin['admin']->admin->logo  }} 2x" alt="logo-dark" />
                </a>
            </div>
        @else
            <div class="brand-logo">
                <a href="/" class="logo-link">
                    <img class="logo-light logo-img logo-img-lg" src="{{ asset('images/cogni_logo_reg.png') }}"
                        srcset="{{ asset('images/cogni_logo_reg.png') }} 2x" alt="logo" />
                    <img class="logo-dark logo-img logo-img-lg" src="{{ asset('images/cogni_logo_reg.png') }}"
                        srcset="{{ asset('images/cogni_logo_reg.png') }} 2x" alt="logo-dark" />
                </a>
            </div>
        @endif
        @endif
    </div>

    <!-- Translation wrapper -->
    <div class="col-6 d-flex justify-content-end align-items-center">
        @php
            $__languages = \Helpers\JSON::parseFile('languages.json');
            $__user_lang = $__languages[request()->cookie('language') ?? 'en'];
            $__get_flag = fn($name) => asset(sprintf('images/flags/%s.png', strtolower($name)));
        @endphp
        <div class="dropdown language-dropdown">
            <div class="dropdown-toggle nk-quick-nav-icon" data-toggle="dropdown" aria-expanded="true">
                <div class="user-avatar xs border border-light">
                    <img src="{{ $__get_flag($__user_lang['flag']) }}" alt="{{ $__user_lang['name'] }}" />
                </div>
            </div>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-s1" x-placement="bottom-end"
                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 38px, 0px);">
                <ul class="language-list">
                    @foreach ($__languages as $__code => $__language)
                        <li>
                            <a href="{{ route('language.update', ['lang' => $__code]) }}" class="language-item">
                                <img src="{{ str_replace('-sq', '', $__get_flag($__language['flag'])) }}"
                                    class="language-flag" alt="{{ $__language['name'] }}" />
                                <span class="language-name">{{ $__language['name'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
