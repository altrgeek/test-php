<x-dashboard title="Dashboard Details" description="Welcome to Cogni&trade; XR Health Dashboard.">
    {{-- Additonal header content --}}
    <x-slot name="header">
        <div class="toggle-wrap nk-block-tools-toggle">
            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em
                    class="icon ni ni-more-v"></em></a>
            <div class="toggle-expand-content" data-content="pageMenu">
                <ul class="nk-block-tools g-3">
                    <li>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light"
                                data-toggle="dropdown"><em
                                    class="d-none d-sm-inline icon ni ni-calender-date"></em><span><span
                                        class="d-none d-md-inline">Last</span> 30 Days</span><em
                                    class="dd-indc icon ni ni-chevron-right"></em></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="link-list-opt no-bdr">
                                    @if (Session::has('token'))
                                        <input type="hidden" id="getSessionToken" data-token="{{ Session::get('token') }}">
                                    @endif
                                    <li><a href="#"><span>Last 30 Days</span></a></li>
                                    <li><a href="#"><span>Last 6 Months</span></a></li>
                                    <li><a href="#"><span>Last 1 Years</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </x-slot>

    {{-- Main content --}}
    <div class="row g-gs">
        <div class="col-xxl-6">
            <div class="row g-gs">
                <x-dashboard.cards.user icon="users" label="Total Users" :count="$users" percentage="0" />
                <x-dashboard.cards.user icon="account-setting" label="Total Admins" :count="$admins" percentage="0" />
                <x-dashboard.cards.user icon="user-list" label="Total Providers" :count="$providers" percentage="0" />
                <x-dashboard.cards.user icon="users" label="Total Clients" :count="$clients" percentage="0" />
                <x-dashboard.cards.user icon="calendar-booking" label="Total Appointments" :count="$appointments['total']" percentage="0" />
                <x-dashboard.cards.user icon="calendar-check" label="Meetings Done" :count="$appointments['completed']" percentage="0" />
            </div><!-- .row -->
        </div><!-- .col -->

        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-6">
                    <div class="nk-download">
                        <div class="data">
                            {{--  <div class="thumb"><img src="./images/icons/product-pp.svg" alt=""></div>  --}}
                            <div class="info">
                                <h6 class="title"><span class="name">API key</span></h6>
                                <div class="meta">
                                    <span class="version">
                                        <span class="text-soft">Token: </span> <span>{{ env('API_TOKEN_AI') }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- .sp-pdl-item -->
                </div>
            </div><!-- .row -->
        </div><!-- .col -->
    </div>
</x-dashboard>
