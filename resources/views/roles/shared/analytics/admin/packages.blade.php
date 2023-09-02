<x-dashboard title="Admin's Packages Analysis">
    @php
        $__columns = [
            'Name',
            'Price',
            'Earnings',
            'Sales',
            'Created At'
        ];
    @endphp
    <div class="card h-100">
        <div class="card-inner mb-n2">
            <div class="card-title-group">
                <div class="card-title card-title-sm">
                    <h6 class="title">Admin Packages</h6>
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
            @foreach ($packages as $package)
                <div class="nk-tb-item">
                    <div class="nk-tb-col">
                        <span class="tb-lead">{{ $package->name }}</span>
                    </div>
                    <div class="nk-tb-col">
                        @if ($package->price)
                            <span class="tb-sub tb-amount">
                                USD {{ $package->price }}
                            </span>
                        @else
                            <span>Free</span>
                        @endif
                    </div>
                    <div class="nk-tb-col">
                        @if ($package->earnings)
                            <span class="tb-sub tb-amount">
                                USD {{ $package->earnings }}
                            </span>
                        @else
                            <span>None</span>
                        @endif
                    </div>
                    <div class="nk-tb-col">
                        @if ($package->sales)
                            <span class="tb-sub tb-amount">
                                {{ $package->sales }}
                            </span>
                        @else
                            <span>None</span>
                        @endif
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">
                            <span>{{ $package->created_at->diffForHumans() }}</span>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-dashboard>
