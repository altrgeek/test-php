<x-dashboard title="Admins Analysis">
    @php
        $__columns = [
            'Name',
            'Providers',
            'Clients',
            'Earnings',
            'Packages',
            'Joined'
        ];
    @endphp
    <div class="card h-100">
        <div class="card-inner mb-n2">
            <div class="card-title-group">
                <div class="card-title card-title-sm">
                    <h6 class="title">Admin Statistics</h6>
                    <p>Analyze your admins performance and take appropriate actions.</p>
                </div>
            </div>
        </div>
        <div class="nk-tb-list is-loose traffic-channel-table">
            <div class="nk-tb-item nk-tb-head">
                @foreach ($__columns as $column)
                    <div class="nk-tb-col">
                        <span>{{ $column }}</span>
                    </div>
                @endforeach
            </div>
            @foreach ($admins as $admin)
                <div class="nk-tb-item">
                    <div class="nk-tb-col">
                        <span class="tb-lead">{{ $admin->name }}</span>
                    </div>
                    <div class="nk-tb-col">
                        @if ($admin->providers)
                            <span class="tb-sub tb-amount">
                                <a
                                    href="{{
                                        route('dashboard.analytics.providers', [
                                            'admin' => $admin->id
                                        ])
                                    }}"
                                    target="_self"
                                >
                                    {{ $admin->providers }}
                                </a>
                            </span>
                        @else
                            <span>None</span>
                        @endif
                    </div>
                    <div class="nk-tb-col">
                        @if ($admin->clients)
                            <span class="tb-sub tb-amount">
                                <a
                                    href="{{
                                        route('dashboard.analytics.clients', [
                                            'admin' => $admin->id
                                        ])
                                    }}"
                                    target="_self"
                                >
                                    {{ $admin->clients }}
                                </a>
                            </span>
                        @else
                            <span>None</span>
                        @endif
                    </div>
                    <div class="nk-tb-col">
                        @if ($admin->earnings)
                            <span class="tb-sub tb-amount">
                                USD {{ $admin->earnings }}
                            </span>
                        @else
                            <span>None</span>
                        @endif
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">
                            @if ($admin->packages)
                            <span class="tb-sub tb-amount">
                                <a
                                    href="{{
                                        route('dashboard.analytics.admin.packages', $admin->id)
                                    }}"
                                    target="_self"
                                >
                                    {{ $admin->packages }}
                                </a>
                            </span>
                        @else
                            <span>None</span>
                        @endif
                        </span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">
                            <span>{{ $admin->joined->diffForHumans() }}</span>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-dashboard>
