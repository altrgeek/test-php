<x-app>
    <div class="nk-block">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">All Clients</h3>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="card card-preview mt-5">
        <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false"
            id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info">
            <thead>
                <tr>
                    <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                        aria-label="User: activate to sort column ascending">
                        <span class="sub-text">Client name</span>
                    </th>
                    <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                        colspan="1" aria-label="Balance: activate to sort column ascending">
                        <span class="sub-text">Email</span>
                    </th>
                    <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                        colspan="1" aria-label="Phone: activate to sort column ascending">
                        <span class="sub-text">Address</span>
                    </th>
                    <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                        colspan="1" aria-label="Verified: activate to sort column ascending">
                        <span class="sub-text">Date of birth</span>
                    </th>
                    <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                        colspan="1" aria-label="Last Login: activate to sort column ascending">
                        <span class="sub-text">Phone number</span>
                    </th>
                    <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                        colspan="1" aria-label="Status: activate to sort column ascending">
                        <span class="sub-text">Gender</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr class="nk-tb-item odd">
                        {{-- Full name --}}
                        <td class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-info">
                                    <span class="tb-lead">
                                        {{ $client->name }}
                                        <span class="dot dot-success d-md-none ml-1"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                        {{-- Email address --}}
                        <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                            <span class="tb-amount">{{ $client->email }}</span>
                        </td>
                        {{-- Residential address --}}
                        <td class="nk-tb-col tb-col-md">
                            <span>
                                {{ $client->address ?? 'Not added Yet' }}
                            </span>
                        </td>
                        {{-- Date of Birth --}}
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                {{ $client->DOB ?? 'Not added Yet' }}
                            </span>
                        </td>
                        {{-- Phone number --}}
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                {{ $client->phone ?? 'Not added Yet' }}
                            </span>
                        </td>
                        {{-- Gender --}}
                        <td class="nk-tb-col tb-col-md">
                            <span>
                                {{ $client->gender ?? 'Not selected Yet' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app>
