<x-app>

    {{-- Alert response --}}
    <x-layout.alert />

    {{-- Header --}}
    <div class="nk-block">
        <div class="nk-block-between">
            {{-- Page title --}}
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Package Management</h3>
            </div>
            {{-- Add resource action button --}}
            <div class="nk-block-head-content">
                <a class="btn btn-primary" data-toggle="modal" data-target="#addPackageModal">
                    <em class="icon ni ni-plus"></em>
                    <span>Add Package</span>
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
                    <th class="nk-tb-col sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable" rowspan="1"
                        colspan="1" aria-label="User: activate to sort column ascending">
                        <span class="sub-text">Package name</span>
                    </th>
                    <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                        <span class="sub-text">Number of Sessions</span>
                    </th>
                    <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                        <span class="sub-text">Description</span>
                    </th>
                    <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                        <span class="sub-text">Price</span>
                    </th>
                    <th class="nk-tb-col nk-tb-col-tools text-right sorting" tabindex="0"
                        aria-controls="Admin_Accounts_DataTable" rowspan="1" colspan="1"
                        aria-label=" activate to sort column ascending">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($packages as $package)
                    <tr class="nk-tb-item odd">
                        <td class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-info">
                                    <span class="tb-lead">{{ $package->title }} <span
                                            class="dot dot-success d-md-none ml-1"></span></span>
                                </div>
                            </div>
                        </td>
                        <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                            <span class="tb-amount">{{ $package->sessions }}</span>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <span>
                                {{ $package->description ?? 'Not added yet' }}
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                {{ $package->price ?? 'Not added yet' }}
                            </span>
                        </td>
                        {{-- subscription actions item (upate and delete) --}}
                        <td class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                            data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="link-list-opt no-bdr">
                                                {{-- Update subscription action --}}
                                                <li>
                                                    <a class="edit-user-btn" data-toggle="modal"
                                                        data-target="#updatePackageModal"
                                                        data-package_id="{{ $package->id }}"
                                                        data-package_title="{{ $package->title }}"
                                                        data-package_sessions="{{ $package->sessions }}"
                                                        data-package_description="{{ $package->description }}"
                                                        data-package_price="{{ $package->price }}">
                                                        <em class="icon ni ni-edit-alt"></em>
                                                        <span>Edit Package</span>
                                                    </a>
                                                </li>
                                                {{-- Delete subscription action --}}
                                                <li>
                                                    <a data-package_id="{{ $package->id }}"
                                                        class="delete-client-btn">
                                                        <em class="icon ni ni-cross-circle"></em>
                                                        <span>Delete Package</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modals will be injected in appropriate location --}}
    <x-slot name="modals">
        {{-- Create admin modal --}}
        <div class="modal fade" id="addPackageModal">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    {{-- Modal Header --}}
                    <div class="modal-header">
                        <h5 class="modal-title">Create Package</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>

                    {{-- Modal Content --}}
                    <div class="modal-body">
                        <form action="{{ route('admin.dashboard.packages.create', ':id') }}"
                            class="form-validate is-alter" method="POST">
                            @csrf
                            <div class="row gx-4 gy-3">
                                {{-- Package title --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Package_title">Package title</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Enter title" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Number of Sessions --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Package_sessions">Number of Sessions</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="sessions"
                                                placeholder="Enter sessions" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Package_description">Description</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="description"
                                            placeholder="Enter description" required />
                                        </div>
                                    </div>
                                </div>
                                {{-- Price --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Package_price">Price</label>
                                        <div class="form-control-wrap">
                                            <div class="number-input">
                                                <input type="number" class="form-control" name="price"
                                                placeholder="Enter price" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Submit button --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Update existing admin modal --}}
        <div class="modal fade" id="updatePackageModal">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    {{-- Modal Header --}}
                    <div class="modal-header">
                        <h5 class="modal-title">Update Package</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    {{-- Modal Content --}}
                    <div class="modal-body">
                        <form action=" {{ route('admin.dashboard.packages.update', ':id') }}" id="editEventForm"
                            enctype="multipart/form-data" class="form-validate is-alter" novalidate="novalidate"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <input hidden name="package_id" id="update_package_id">
                            <div class="row gx-4 gy-3">

                                {{-- Package Title --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Package_title">Package Title</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="title" id="update_package_title"
                                                placeholder="Enter title" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Number of Sessions --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Package_sessions">Number of Sessions</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="sessions" id="update_package_sessions"
                                                placeholder="Enter sessions" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Package_descriotion">Description</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="description" id="update_package_description"
                                            placeholder="Enter description" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Price --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Package_price">Price</label>
                                        <div class="form-control-wrap">
                                            <div class="number_input">
                                                <input type="number" class="form-control" name="price" id="update_package_price"
                                                placeholder="Enter price" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <button id="addEvent" type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <form action="" method="POST" id="deleteEventForm">
            @csrf
            @method('DELETE')
        </form>
    </x-slot>

    {{-- Additonal scripts for current page --}}
    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $(".edit-user-btn").click(function() {
                    let package_id = $(this).data('package_id');
                    let package_title = $(this).data('package_title');
                    let package_sessions = $(this).data('package_sessions');
                    let package_description = $(this).data('package_description');
                    let package_price = $(this).data('package_price');
                    let url = $('#editEventForm').attr('action');

                    url = url.replace(':id', package_id);
                    $("#update_package_id").val(package_id);
                    $("#update_package_title").val(package_title);
                    $("#update_package_sessions").val(package_sessions);
                    $("#update_package_description").val(package_description);
                    $("#update_package_price").val(package_price);
                    $('#editEventForm').attr('action', url);
                });
                $(".delete-client-btn").click(function(e) {
                    e.preventDefault();
                    var user_id = $(this).data('package_id');
                    var url = '{{ route('admin.dashboard.packages.delete', ':id') }}';
                    url = url.replace(':id', user_id);

                    Swal.fire({
                        title: 'Are you sure you want to delete?',
                        text: 'The package will be deleted!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e85347',
                        cancelButtonColor: '#854fff',
                        confirmButtonText: 'Delete!'
                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            const deleteForm = $('#deleteEventForm');
                            deleteForm.attr('action', url);
                            deleteForm.submit();
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-app>
