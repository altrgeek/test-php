<x-dashboard title="Client's Sessions Analysis">
    @php
        $__columns = [
            'ID',
            'Duration',
            'Platform',
            'Start',
            'Payment',
            'Status',
        ];
    @endphp
    <div class="card h-100">
        <div class="card-inner mb-n2">
            <div class="card-title-group">
                <div class="card-title card-title-sm">
                    <h6 class="title">Client Sessions</h6>
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
            @foreach ($sessions as $session)
                <div class="nk-tb-item">
                    <div class="nk-tb-col">
                        <span class="tb-lead">{{ $session->id }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span>{{ $session->duration }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span>
                            {{ $session->platform }}
                        </span>
                    </div>
                    <div class="nk-tb-col">
                        <span>
                            {{ $session->start->format('d-m-Y g:i A') }}
                        </span>
                    </div>
                    <div class="nk-tb-col">
                        @if ($session->payment)
                            <span class="tb-sub tb-amount">
                                USD {{ $session->payment }}
                            </span>
                        @else
                            <span>Free</span>
                        @endif
                    </div>
                    <div class="nk-tb-col">
                        <span>
                            {{ ucfirst($session->status) }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-dashboard>
