<x-dashboard title="Client's Purchases Analysis">
    @php
        $__columns = [
            'Transaction ID',
            'Product',
            'Amount',
            'Purchased On'
        ];
    @endphp
    <div class="card h-100">
        <div class="card-inner mb-n2">
            <div class="card-title-group">
                <div class="card-title card-title-sm">
                    <h6 class="title">Client's Purchases</h6>
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
            @foreach ($transactions as $transaction)
                <div class="nk-tb-item">
                    <div class="nk-tb-col">
                        <span>{{ $transaction->id }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-lead text-capitalize">{{ $transaction->product }}</span>
                    </div>
                    <div class="nk-tb-col">
                        @if ($transaction->amount)
                            <span class="tb-sub tb-amount">
                                USD {{ $transaction->amount }}
                            </span>
                        @else
                            <span>Free</span>
                        @endif
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">
                            <span>{{ $transaction->purchased_on }}</span>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-dashboard>
