<x-dashboard title="Clients Analysis">
    @php
        $__columns = [
            'Name',
            'Sessions',
            'Spending',
            'Packages',
            'Joined',
        ];
    @endphp
    <div class="card h-100">
        <div class="card-inner mb-n2">
            <div class="card-title-group">
                <div class="card-title card-title-sm">
                    <h6 class="title">Client Statistics</h6>
                    <p>Analyze your clients performance and take appropriate actions.</p>
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
            @foreach ($clients as $client)
                <div class="nk-tb-item">
                    <div class="nk-tb-col">
                        <span class="tb-lead">{{ $client->name }}</span>
                    </div>
                    <div class="nk-tb-col">
                        @if ($client->sessions)
                            <span class="tb-sub tb-amount">
                                <a
                                    href="{{ route('dashboard.analytics.client.sessions', $client->id) }}"
                                    target="_self"
                                >
                                    {{ $client->sessions }}
                                </a>
                            </span>
                        @else
                            <span>None</span>
                        @endif
                    </div>
                    <div class="nk-tb-col">
                        @if ($client->spending)
                            <span class="tb-sub tb-amount">
                                <a
                                    href="{{ route('dashboard.analytics.client.spending', $client->id) }}"
                                    target="_self"
                                >
                                    USD {{ $client->spending }}
                                </a>
                            </span>
                        @else
                            <span>None</span>
                        @endif
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">
                            @if ($client->packages)
                            <span class="tb-sub tb-amount">
                                <a
                                    href="{{ route('dashboard.analytics.client.packages', $client->id) }}"
                                    target="_self"
                                >
                                    {{ $client->packages }}
                                </a>
                            </span>
                        @else
                            <span>None</span>
                        @endif
                        </span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">
                            <span>{{ $client->joined->diffForHumans() }}</span>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-dashboard>
