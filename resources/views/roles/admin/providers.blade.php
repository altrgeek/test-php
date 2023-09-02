<x-dashboard title="Health Providers Management">
    {{-- Header --}}
    <div class="nk-block">
        <div class="nk-block-between">
            {{-- Page title --}}
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title"></h3>
            </div>
            {{-- Add resource action button --}}
            <div class="nk-block-head-content">
                <a class="btn btn-primary" data-toggle="modal" data-target="#addProviderModal">
                    <em class="icon ni ni-plus"></em>
                    <span>Add Practitioner</span>
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
                        <span class="sub-text">Practitioner Name</span>
                    </th>
                    <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                        <span class="sub-text">Email</span>
                    </th>
                    <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                        <span class="sub-text">Address</span>
                    </th>
                    <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                        <span class="sub-text">Date of Birth</span>
                    </th>
                    <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Last Login: activate to sort column ascending">
                        <span class="sub-text">Phone Number</span>
                    </th>
                    <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">
                        <span class="sub-text">Gender</span>
                    </th>
                    <th class="nk-tb-col nk-tb-col-tools text-right sorting" tabindex="0"
                        aria-controls="Admin_Accounts_DataTable" rowspan="1" colspan="1"
                        aria-label=" activate to sort column ascending">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($providers as $provider)
                    <tr class="nk-tb-item odd">
                        <td class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-info">
                                    <span class="tb-lead">{{ $provider->name }} <span
                                            class="dot dot-success d-md-none ml-1"></span></span>

                                </div>
                            </div>
                        </td>
                        <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                            <span class="tb-amount">{{ $provider->email }}</span>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <span>
                                {{ $provider->address ?? 'Not added yet' }}
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                {{ $provider->dob ?? 'Not added yet' }}
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                {{ $provider->phone ?? 'Not added yet' }}
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <span>
                                {{ $provider->gender ?? 'Not choosen yet' }}
                            </span>
                        </td>
                        {{-- Admin actions item (upate and delete) --}}
                        <td class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                            data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="link-list-opt no-bdr">
                                                {{-- Update provider action --}}
                                                <li>
                                                    <a class="edit-user-btn" data-toggle="modal"
                                                        data-target="#updateAdminModal"
                                                        data-provider_id="{{ $provider->provider_id }}"
                                                        data-provider_name="{{ $provider->name }}"
                                                        data-provider_email="{{ $provider->email }}">
                                                        <em class="icon ni ni-edit-alt"></em>
                                                        <span>Edit Provider</span>
                                                    </a>
                                                </li>
                                                {{-- Delete provider action --}}
                                                <li>
                                                    <a data-user_id="{{ $provider->provider_id }}" class="delete-client-btn">
                                                        <em class="icon ni ni-cross-circle"></em>
                                                        <span>Delete Provider</span>
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
        <div class="modal fade" id="addProviderModal">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    {{-- Modal Header --}}
                    <div class="modal-header">
                        <h5 class="modal-title">Create Health Practitioner</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>

                    {{-- Modal Content --}}
                    <div class="modal-body">
                        <form action="{{ route('admin.dashboard.providers.create') }}"
                            class="form-validate is-alter"
                            method="POST">
                            @csrf

                            <div id="errors">
                            </div>

                            <div class="row gx-4 gy-3">
                                {{-- Full name --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="provider_name">Practitioner Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Enter full name" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Email address --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="provider_email">Practitioner Email</label>
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control" name="email" id="email-address"
                                                placeholder="Enter email address" required />
                                        </div>
                                    </div>
                                </div>
                                 <!-- Speciality -->
                                 <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 12px" for="dobInputField">
                                            Speciality
                                        </label>
                                        <div class="form-control-wrap">
                                            <select  class="form-select js-select2 select2-hidden-accessible" multiple=""
            data-placeholder="Select Speciality" name="speciality" data-maximum-selection-length="3" tabindex="-1"
            aria-hidden="true">
                                                <option value="Psychiatrist">Psychiatrist </option>
                                                <option value="Psychiatric nurse">Psychiatric nurse</option>
                                                <option value="Psychotherapist">Psychotherapist </option>
                                                <option value="Mental health counselor">Mental health counselor</option>
                                                <option value="Family and marriage counselor">Family and marriage counselor </option>
                                                <option value="Addiction counselor">Addiction counselor</option>
                                                <option value="Religious counselor">Religious counselor </option>
                                                <option value="Art therapist">Art therapist</option>
                                                <option value="Social worker">Social worker</option>
                                                <option value="Training">Training</option>
                                                <option value="sexologist">sexologist</option>
                                                <option value="psychoeducation">psychoeducation</option>
                                                <option value="Traumatologist">Traumatologist</option>
                                                <option value="Substance abuse specialist ">Substance abuse specialist </option>
                                                <option value="Other">Other </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Client Profiles -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 12px" for="dobInputField">
                                            Client Profiles
                                        </label>
                                        <div class="form-control-wrap">
                                            <select class="form-control" id="default-06" name="accept_clients">
                                                <option value="default_option" selected disabled>Select Option</option>
                                                <option value="Youths 12-25 ">Youths 12-25 </option>
                                                <option value="Young adults: 25-35"> Young adults: 25-35</option>
                                                <option value="Adults 35-55">Adults 35-55</option>
                                                <option value="55-65+">55-65+</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="provider_password">Provider Password</label>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Enter temporary password" required />
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
        <div class="modal fade" id="updateAdminModal">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    {{-- Modal Header --}}
                    <div class="modal-header">
                        <h5 class="modal-title">Update Admin</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    {{-- Modal Content --}}
                    <div class="modal-body">
                        <form action="{{ route('admin.dashboard.providers.edit', ':id') }}" id="editEventForm"
                            enctype="multipart/form-data" class="form-validate is-alter" novalidate="novalidate"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <input hidden name="id" id="update_provider_id">

                            {{-- Full anem --}}
                            <div class="row gx-4 gy-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="provider_name">Provier Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="update_provider_name"
                                                name="name" required>
                                        </div>
                                    </div>
                                </div>

                                {{-- Email address --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="provider_email">Provider Email</label>
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control" id="update_provider_email"
                                                name="email" required>
                                        </div>
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="provider_password">Provider Password</label>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control" name="update_password"
                                                id="provider_password" >
                                        </div>
                                    </div>
                                </div>

                                {{-- Update button --}}
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
    </x-slot>
    <form action="{{ route('admin.dashboard.providers.delete', ':id') }}" method="POST" id="deleteEventForm">
        @csrf
        @method('DELETE')
        </form>
    {{-- Additonal scripts for current page --}}
    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $(".edit-user-btn").click(function() {
                    let provider_id = $(this).data('provider_id');
                    let provider_name = $(this).data('provider_name');
                    let provider_email = $(this).data('provider_email');
                    let provider_password = $(this).data('provider_password');
                    let url =  $('#editEventForm').attr('action');

                    url = url.replace(':id', provider_id);
                    $("#update_provider_id").val(provider_id);
                    $("#update_provider_name").val(provider_name);
                    $("#update_provider_email").val(provider_email);
                    $("#update_password").val(provider_password);
                    $('#editEventForm').attr('action',url );
                });
                $(".delete-client-btn").click(function(e) {
                    e.preventDefault();
                    var user_id = $(this).data('user_id');
                    var url = '{{ route('admin.dashboard.providers.delete', ':id') }}';
                    url = url.replace(':id', user_id);

                    Swal.fire({
                        title: 'Are you sure you want to delete?',
                        text: 'All records related to this will be deleted!',
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
</x-dashboard>
