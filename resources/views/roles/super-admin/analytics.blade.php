<x-dashboard title="Providers Analysis">
    @php
        $__columns = [
            'Name',
            'Clients',
            'Sessions Taken',
            'Earnings',
            'Therapies Providing',
            'Joined'
        ];
    @endphp
    <div class="card h-100">
        <div class="card-inner mb-n2">
            <div class="card-title-group">
                <div class="card-title card-title-sm">
                    <h6 class="title">Provider Statistics</h6>
                    <p>Analyze your providers performance and take appropriate actions.</p>
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
            @foreach ($providers as $provider)
                <div class="nk-tb-item">
                    <div class="nk-tb-col">
                        <span class="tb-lead">{{ $provider->name }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span>{{ $provider->clients }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span>{{ $provider->sessions }}</span>
                    </div>
                    <div class="nk-tb-col">
                        @if ($provider->earnings)
                            <span class="tb-sub tb-amount">
                                USD {{ $provider->earnings }}
                            </span>
                        @else
                            <span>None</span>
                        @endif
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">
                            <span>{{ $provider->therapies }}</span>
                        </span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">
                            <span>{{ $provider->joined->diffForHumans() }}</span>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-dashboard>
