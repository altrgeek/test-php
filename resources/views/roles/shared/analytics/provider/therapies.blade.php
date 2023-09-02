<x-dashboard title="Provider's Therapies Analysis">
    @php
        $__columns = [
            'ID',
            'Name',
            'Options',
            'Created At',
        ];
    @endphp
    <div class="card h-100">
        <div class="card-inner mb-n2">
            <div class="card-title-group">
                <div class="card-title card-title-sm">
                    <h6 class="title">Service Provider's Therapies</h6>
                    <p>Analyze the service providers's therapies and take appropriate actions.</p>
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
            @foreach ($therapies as $therapy)
                <div class="nk-tb-item">
                    <div class="nk-tb-col">
                        <span class="tb-lead">{{ $therapy->id }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-lead">{{ $therapy->name }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span>{{ $therapy->options }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span>
                            {{ $therapy->created_at->format('d-m-Y g:i A') }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-dashboard>
