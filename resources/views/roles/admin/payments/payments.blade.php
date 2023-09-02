<x-app>

    {{-- Alert response --}}
    <x-layout.alert />

    {{-- Header --}}
    <div class="nk-block">
        <div class="nk-block-between">
            {{-- Page title --}}
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Invoice Management</h3>
            </div>
        </div>
    </div>

    {{-- Records table --}}
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Invoices</h3>
                                <div class="nk-block-des text-soft">
                                    <p>You have total {{ $orders->count() }} orders invoices,</p>
                                    <p>{{ $subscriptions->count() }} subscriptions invoices.</p>
                                    <p>& {{ $bought_packages->count() }} packages invoices.</p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false"
                                    id="Admin_Accounts_DataTable" aria-describedby="Admin_Accounts_DataTable_info">
                                        <thead class="tb-odr-head">
                                            <tr class="tb-odr-item">
                                                <th class="tb-odr-info">
                                                    <span class="tb-odr-id">Order ID</span>
                                                    <span class="tb-odr-id">Subscription ID</span>
                                                    <span class="tb-odr-id">Package ID</span>
                                                    <span class="tb-odr-date d-none d-md-inline-block">Date</span>
                                                </th>
                                                <th class="tb-odr-amount">
                                                    <span class="tb-odr-total">Amount</span>
                                                    <span class="tb-odr-status d-none d-md-inline-block">Status</span>
                                                </th>
                                                {{-- <th class="tb-odr-action">&nbsp;</th> --}}
                                                <th class="nk-tb-col nk-tb-col-tools text-right sorting" tabindex="0"
                                                aria-controls="Admin_Accounts_DataTable" rowspan="1" colspan="1"
                                                aria-label=" activate to sort column ascending">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tb-odr-body">
                                            {{-- retrieveing orders --}}
                                            @foreach ($orders as $order)
                                                <tr class="tb-odr-item">
                                                    <td class="tb-odr-info">
                                                        <span class="tb-odr-id"><a>{{ $order->id }}</a></span>
                                                        <span class="tb-odr-id"></span>
                                                        <span class="tb-odr-id"></span>
                                                        <span class="tb-odr-date">{{ $order->created_at }}</span>
                                                    </td>
                                                    <td class="tb-odr-amount">
                                                        <span class="tb-odr-total">
                                                            <span class="amount">${{ $order->amount }}</span>
                                                        </span>
                                                        <span class="tb-odr-status">
                                                            @if ($order->status === "unpaid")
                                                            <span class="badge badge-dot badge-warning">{{ $order->status }}</span>
                                                            @elseif ($order->status === "paid")
                                                            <span class="badge badge-dot badge-success">{{ $order->status }}</span>
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td class="tb-odr-action">
                                                        <div class="tb-odr-btns d-none d-sm-inline">
                                                            <a href="{{ route('admin.dashboard.payments.show', $order->id) }}" class="btn btn-dim btn-sm btn-primary">View</a>
                                                        </div>
                                                        <a href="html/invoice-details.html" class="btn btn-pd-auto d-sm-none"><em class="icon ni ni-chevron-right"></em></a>
                                                    </td>
                                                </tr><!-- .tb-odr-item -->
                                            @endforeach

                                            {{-- retrieveing subscriptions --}}
                                            @foreach ($subscriptions as $subscription)
                                                <tr class="tb-odr-item">
                                                    <td class="tb-odr-info">
                                                        <span class="tb-odr-id"></span>
                                                        <span class="tb-odr-id"><a>{{ $subscription->id }}</a></span>
                                                        <span class="tb-odr-id"></span>
                                                        <span class="tb-odr-date">{{ $subscription->created_at }}</span>
                                                    </td>
                                                    <td class="tb-odr-amount">
                                                        <span class="tb-odr-total">
                                                            <span class="amount">${{ $subscription->price }}</span>
                                                        </span>
                                                    </td>
                                                    <td class="tb-odr-action">
                                                        <div class="tb-odr-btns d-none d-sm-inline">
                                                            <a href="{{ route('admin.dashboard.subscriptions.show', $subscription->subscriptions_id) }}" class="btn btn-dim btn-sm btn-primary">View</a>
                                                        </div>
                                                        <a href="html/invoice-details.html" class="btn btn-pd-auto d-sm-none"><em class="icon ni ni-chevron-right"></em></a>
                                                    </td>
                                                </tr><!-- .tb-odr-item -->
                                            @endforeach

                                            {{-- retrieveing packages --}}
                                            @foreach ($bought_packages as $packages)
                                                <tr class="tb-odr-item">
                                                    <td class="tb-odr-info">
                                                        <span class="tb-odr-id"></span>
                                                        <span class="tb-odr-id"></span>
                                                        <span class="tb-odr-id"><a>{{ $packages->id }}</a></span>
                                                        <span class="tb-odr-date">{{ $packages->created_at }}</span>
                                                    </td>
                                                    <td class="tb-odr-amount">
                                                        <span class="tb-odr-total">
                                                            <span class="amount">${{ $packages->amount }}</span>
                                                        </span>
                                                    </td>
                                                    <td class="tb-odr-action">
                                                        <div class="tb-odr-btns d-none d-sm-inline">
                                                            <a href="{{ route('admin.dashboard.packages.show', $packages->id) }}" class="btn btn-dim btn-sm btn-primary">View</a>
                                                        </div>
                                                        <a href="html/invoice-details.html" class="btn btn-pd-auto d-sm-none"><em class="icon ni ni-chevron-right"></em></a>
                                                    </td>
                                                </tr><!-- .tb-odr-item -->
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div><!-- .card-inner -->
                            </div><!-- .card-inner-group -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>

    {{-- Additonal scripts for current page --}}
    <x-slot name="scripts">
    </x-slot>
</x-app>
