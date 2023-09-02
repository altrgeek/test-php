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
    @foreach ($transaction as $trans)
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Invoice <strong class="text-primary small"></strong></h3>
                                <div class="nk-block-des text-soft">
                                    <ul class="list-inline">
                                        <li>Created At: {{ ($trans->subscriptions->created_at)->format('Y-m-d') }} <span class="text-base"></span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <a href="{{ route('admin.dashboard.payments') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                <a href="{{ route('admin.dashboard.payments') }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="invoice">
                            <div class="invoice-action">
                                <a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" href="html/invoice-print.html" target="_blank"><em class="icon ni ni-printer-fill"></em></a>
                            </div><!-- .invoice-actions -->
                            <div class="invoice-wrap">
                                <div class="invoice-brand text-center">
                                    <img src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="">
                                </div>
                                <div class="invoice-head">
                                    <div class="invoice-contact">
                                        <span class="overline-title">Invoice From</span>
                                        <div class="invoice-contact-info">
                                            <h4 class="title">{{ $trans->user->name }}</h4>
                                        </div>
                                    </div>
                                    <div class="invoice-desc">
                                        <h3 class="title">Invoice</h3>
                                        <ul class="list-plain">
                                            <li class="invoice-id"><span>Invoice ID</span>:<span>{{ $trans->transaction_id }}</span></li>
                                            <li class="invoice-date"><span>Date</span>:<span>{{ ($trans->created_at)->format('Y-m-d') }}</span></li>
                                        </ul>
                                    </div>
                                </div><!-- .invoice-head -->
                                <div class="invoice-bills">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="w-150px">Transaction ID</th>
                                                    <th class="w-60">Order ID</th>
                                                    <th class="w-60">Subscriptions ID</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                        <td>{{ $trans->transaction_id }}</td>
                                                        <td></td>
                                                        <td>{{ $trans->subscriptions->id }}</td>
                                                        <td>${{ $trans->amount }}</td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                        <div class="nk-notes ff-italic fs-12px text-soft"> Invoice was created on a computer and is valid without the signature and seal. </div>
                                    </div>
                                </div><!-- .invoice-bills -->
                            </div><!-- .invoice-wrap -->
                        </div><!-- .invoice -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Additonal scripts for current page --}}
    <x-slot name="scripts">
    </x-slot>
</x-app>
