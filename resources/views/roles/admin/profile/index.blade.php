<x-dashboard>
    <div class="card">
        <div class="card-aside-wrap">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head nk-block-head-lg">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h4 class="nk-block-title">Personal Information</h4>
                            <div class="nk-block-des">
                                <p>
                                    Basic info, like your name and address, that you use on Cogni™
                                    Platform.
                                </p>
                            </div>
                        </div>
                        <div class="nk-block-head-content align-self-start d-lg-none">
                            <a
                                href="#"
                                class="toggle btn btn-icon btn-trigger mt-n1"
                                data-bs-target="profile-edit"
                            >
                                <em class="icon ni ni-menu-alt-r"></em>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="nk-data data-list">
                        <div class="data-head">
                            <h6 class="overline-title">Basics</h6>
                        </div>
                        <div class="data-item" data-toggle="modal" data-bs-target="#profile-edit">
                            <div class="data-col">
                                <span class="data-label">
                                    <a href="{{ route('admin.profile.edit') }}" style="color: #8094ae">
                                        Full Name
                                    </a>
                                </span>
                                <a href="{{ route('admin.profile.edit') }}">
                                    <span class="data-value">{{ $user->name }}</span>
                                </a>
                            </div>
                            <div class="data-col data-col-end">
                                <span class="data-more">
                                    <a href="{{ route('admin.profile.edit') }}">
                                        <em class="icon ni ni-forward-ios"></em>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="data-item">
                            <div class="data-col">
                                <span class="data-label">Email</span>
                                <span class="data-value">{{ $user->email }}</span>
                            </div>
                            <div class="data-col data-col-end">
                                <span class="data-more disable">
                                    <em class="icon ni ni-lock-alt"></em>
                                </span>
                            </div>
                        </div>
                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                            <div class="data-col">
                                <span class="data-label">
                                    <a href="{{ route('admin.profile.edit') }}" style="color: #8094ae">
                                        Phone Number
                                    </a>
                                </span>
                                <span class="data-value text-soft">
                                    {{ $user->phone ?? 'Not added yet' }}
                                </span>
                            </div>
                            <div class="data-col data-col-end">
                                <a href="{{ route('admin.profile.edit') }}" style="color: #8094ae">
                                    <span class="data-more">
                                        <em class="icon ni ni-forward-ios"></em>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                            <div class="data-col">
                                <span class="data-label">
                                    <a href="{{ route('admin.profile.edit') }}" style="color: #8094ae">
                                        Date of Birth
                                    </a>
                                </span>
                                <span class="data-value">
                                    <a href="{{ route('admin.profile.edit') }}" style="color: #8094ae">
                                        {{ $user->dob?->format('jS F Y') ?? 'Not added yet' }}
                                    </a>
                                </span>
                            </div>
                            <div class="data-col data-col-end">
                                <span class="data-more">
                                    <a href="{{ route('admin.profile.edit') }}" style="color: #8094ae">
                                        <em class="icon ni ni-forward-ios"></em>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="data-item" data-toggle="modal" data-target="#profile-edit"
                            data-tab-target="#address">
                            <div class="data-col">
                                <span class="data-label">
                                    <a href="{{ route('admin.profile.edit') }}" style="color: #8094ae">
                                        Address
                                    </a>
                                </span>
                                <span class="data-value">
                                    <a href="{{ route('admin.profile.edit') }}" style="color: #8094ae">
                                        {{ $user->address ?? 'Not added yet' }}
                                    </a>
                                </span>
                            </div>
                            <div class="data-col data-col-end">
                                <span class="data-more">
                                    <a href="{{ route('admin.profile.edit') }}" style="color: #8094ae">
                                        <em class="icon ni ni-forward-ios"></em>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Profile sidebar --}}
            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg toggle-screen-lg"
                data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                <div class="card-inner-group">
                    <div class="card-inner">
                        {{-- Profile overview card (with avatar) --}}
                        <x-dashboard.cards.profile-avatar />
                    </div>

                    {{-- Profile sidebar links --}}
                    <div class="p-0 card-inner">
                        <ul class="link-list-menu">
                            <li>
                                <a href="#" class="nk-menu-link">
                                    <em class="icon ni ni-user-fill-c"></em>
                                    <span>Personal Infomation</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="{{ asset('assets/js/profile.js') }}"></script>
    </x-slot>
</x-dashboard>
