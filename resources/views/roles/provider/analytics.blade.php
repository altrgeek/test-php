<x-dashboard title="Clients Analysis">
    @php
        $__columns = [
            'Name',
            'Sessions Revenue / Count',
            'Packages Revenue / Count',
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
                        @if ($client->appointments->count)
                            <span class="tb-sub tb-amount">
                                    {{ $client->appointments->spending }} USD
                                    ({{ $client->appointments->count }})
                            </span>
                        @else
                            <span>None</span>
                        @endif
                    </div>
                    <div class="nk-tb-col">
                        @if ($client->packages->count)
                            <span class="tb-sub tb-amount">
                                    {{ $client->packages->spending }} USD
                                    ({{ $client->packages->count }})
                            </span>
                        @else
                            <span>None</span>
                        @endif
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">
                            <span>{{ $client->joined_at->diffForHumans() }}</span>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-dashboard>
