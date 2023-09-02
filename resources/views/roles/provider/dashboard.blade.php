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
                <x-dashboard.cards.user icon="users" label="Total Clients" :count="$clients" percentage="2.45" />
            </div>
        </div>
    </div>
</x-dashboard>
