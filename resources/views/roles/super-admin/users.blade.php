<x-app>

    {{-- Alert response --}}
    <x-layout.alert />

    {{-- Header --}}
    <div class="nk-block">
        <div class="nk-block-between">
            {{-- Page title --}}
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Users Management</h3>
            </div>

            {{-- Add resource action button --}}
            <div class="nk-block-head-content d-flex justify-content-end">
                <a class="btn btn-primary" data-toggle="modal" data-target="#filterResourceModal">
                    <em class="icon ni ni-plus"></em>
                    <span>Fitler</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Records table --}}
    <div class="card card-preview mt-5">
        <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false"
            id="Admin_Accounts_DataTable" aria-describedby="Admin_Accounts_DataTable_info">
            <thead>
                <tr>
                    <!-- Name -->
                    <th
                        class="nk-tb-col sorting"
                        tabindex="0"
                        aria-controls="Admin_Accounts_DataTable"
                        rowspan="1"
                        colspan="1"
                        aria-label="User: activate to sort column ascending"
                    >
                        <span class="sub-text">Name</span>
                    </th>

                    <!-- Email address -->
                    <th
                        class="nk-tb-col sorting"
                        tabindex="0"
                        aria-controls="Admin_Accounts_DataTable"
                        rowspan="1"
                        colspan="1"
                        aria-label="User: activate to sort column ascending"
                    >
                        <span class="sub-text">Email</span>
                    </th>

                    <!-- Phone number -->
                    <th
                        class="nk-tb-col sorting"
                        tabindex="0"
                        aria-controls="Admin_Accounts_DataTable"
                        rowspan="1"
                        colspan="1"
                        aria-label="User: activate to sort column ascending"
                    >
                        <span class="sub-text">Phone Number</span>
                    </th>

                    <!-- Role -->
                    <th
                        class="nk-tb-col sorting"
                        tabindex="0"
                        aria-controls="Admin_Accounts_DataTable"
                        rowspan="1"
                        colspan="1"
                        aria-label="User: activate to sort column ascending"
                    >
                        <span class="sub-text">Role</span>
                    </th>

                    <!-- Actions -->
                    <th
                        class="nk-tb-col nk-tb-col-tools text-right sorting"
                        tabindex="0"
                        aria-controls="Admin_Accounts_DataTable"
                        rowspan="1"
                        colspan="1"
                        aria-label=" activate to sort column ascending"
                    >
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $role)
                    <tr class="nk-tb-item odd">
                        <!-- Name -->
                        <td class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-info">
                                    <span class="tb-lead">
                                        {{ $role->user->name ?? 'not added yet'}}
                                        <span class="dot dot-success d-md-none ml-1"></span>
                                    </span>
                                </div>
                            </div>
                        </td>

                        <!-- Email address -->
                        <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                            <span class="tb-amount">{{ $role->user->email ?? 'not added yet'}}</span>
                        </td>

                        <!-- Phone -->
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                {{ $role->user->phone ?? 'Not added yet' }}
                            </span>
                        </td>

                        <!-- Role -->
                        <td class="nk-tb-col tb-col-md">
                            <span>{{ ucfirst($role->user->getRole()) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modals will be injected in appropriate location --}}
    <x-slot name="modals">
        {{-- Filter modal --}}
        <div class="modal fade" id="filterResourceModal">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">Filter</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>

                    <!-- Modal Content -->
                    <div class="modal-body">
                        <form
                            action="{{ route('super_admin.dashboard.users') }}"
                            method="GET"
                            class="form-validate is-alter"
                        >
                            <div class="row gx-4 gy-3">
                                <!-- Admin selection -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="userFilterAdminSelectField" class="form-label">Admin</label>
                                        <div class="form-control-wrap">
                                            <select
                                                name="admin_id"
                                                id="userFilterAdminSelectField"
                                                class="form-control"
                                            >
                                                <option selected>Select Admin</option>
                                                @foreach ($admins as $admin)
                                                    <option value="{{ $admin->id }}">{{ $admin->user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Provider selection -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="userFilterProviderSelectField" class="form-label">Provider</label>
                                        <div class="form-control-wrap">
                                            <select
                                                name="provider_id"
                                                id="userFilterProviderSelectField"
                                                class="form-control"
                                            >
                                                <option selected>Select Provider</option>
                                                @foreach ($admins as $admin)
                                                    <optgroup label="{{ $admin->user->name }}">
                                                        @foreach ($admin->providers as $provider)
                                                            <option value="{{ $provider->id }}">{{ $provider->user->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app>
