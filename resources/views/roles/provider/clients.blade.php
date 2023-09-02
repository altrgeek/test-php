<x-dashboard title="Clients Management">
    <x-slot name="addBtn">
        <a class="btn btn-primary" data-toggle="modal" data-target="#addClientModal">
            <em class="icon ni ni-plus"></em>
            <span>Add Client</span>
        </a>
    </x-slot>

    {{-- Records table --}}
    <div class="card card-preview mt-5">
        <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false"
            id="Admin_Accounts_DataTable" aria-describedby="Admin_Accounts_DataTable_info">
            <thead>
                <tr>
                    <th class="nk-tb-col sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable" rowspan="1"
                        colspan="1" aria-label="User: activate to sort column ascending">
                        <span class="sub-text">Client Name</span>
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
                    <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">
                    <span class="sub-text">Bought Packages</span>
                    </th>
                    <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">
                    <span class="sub-text">Sessions</span>
                    </th>
                    <th class="nk-tb-col nk-tb-col-tools text-right sorting" tabindex="0"
                        aria-controls="Admin_Accounts_DataTable" rowspan="1" colspan="1"
                        aria-label=" activate to sort column ascending">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr class="nk-tb-item odd">
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
                        <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                            <span class="tb-amount">{{ $client->email }}</span>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <span>
                                {{ $client->address ?? 'Not added yet' }}
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                {{ $client->dob ?? 'Not added yet' }}
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                {{ $client->phone ?? 'Not added yet' }}
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <span>
                                {{ $client->gender  ?? 'Not choosen yet' }}
                            </span>
                        </td>
                        {{-- @foreach ($client->bought_packages as $package) --}}
                            <td class="nk-tb-col tb-col-md">
                                <span>
                                    {{ $client->title  ?? 'Not bought yet' }}
                                </span>
                            </td>
                            <td class="nk-tb-col tb-col-md">
                                <span>
                                    {{ $client->sessions  ?? 'Not bought yet' }}
                                </span>
                            </td>
                        {{-- @endforeach --}}
                        {{-- Admin actions item (upate and delete) --}}
                        <td class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                            data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="link-list-opt no-bdr">
                                                {{-- Update client action --}}
                                                <li>
                                                    <a class="edit-user-btn" data-toggle="modal"
                                                        data-target="#updateAdminModal"
                                                        data-client_id="{{ $client->client_id }}"
                                                        data-client_name="{{ $client->name }}"
                                                        data-client_email="{{ $client->email }}"
                                                        data-client_password = "{{$client->password}}">
                                                        <em class="icon ni ni-edit-alt"></em>
                                                        <span>Update User</span>
                                                    </a>
                                                </li>
                                                {{-- Delete client action --}}
                                                <li>
                                                    <a data-user_id="{{ $client->client_id }}" class="delete-client-btn">
                                                        <em class="icon ni ni-cross-circle"></em>
                                                        <span>Delete User</span>
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
        <div class="modal fade" id="addClientModal">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    {{-- Modal Header --}}
                    <div class="modal-header">
                        <h5 class="modal-title">Create Client</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>

                    {{-- Modal Content --}}
                    <div class="modal-body">
                        <form action="{{ route('provider.dashboard.clients.create') }}"
                            class="form-validate is-alter" method="POST">
                            @csrf

                            <div id="errors">
                            </div>

                            <div class="row gx-4 gy-3">
                                {{-- Full name --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_name">Client Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Enter full name" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Email address --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_email">Client Email</label>
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control" name="email" id="email-address"
                                                placeholder="Enter email address" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_password">Client Password</label>
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
                        <h5 class="modal-title">Update Client</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    {{-- Modal Content --}}
                    <div class="modal-body">
                        <form action="{{ route('provider.dashboard.clients.update',':id') }}" id="editEventForm"
                            enctype="multipart/form-data" class="form-validate is-alter" novalidate="novalidate"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <input hidden name="id" id="update_client_id">
                            <div class="row gx-4 gy-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_name">Client Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="update_client_name"
                                                name="name" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_email">Client Email</label>
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control" id="update_client_email"
                                                name="email" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_password">Client Password</label>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control" name="update_password"

                                                id="client_password" >

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
    </x-slot>
   <form action="{{ route('provider.dashboard.clients.delete', ':id') }}" method="POST" id="deleteEventForm">
    @csrf
    @method('DELETE')
    </form>
    {{-- Additonal scripts for current page --}}
    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $(".edit-user-btn").click(function() {
                    let client_id = $(this).data('client_id');
                    let client_name = $(this).data('client_name');
                    let client_email = $(this).data('client_email');
                    let client_password = $(this).data('client_password');
                    let url =  $('#editEventForm').attr('action');

                    url = url.replace(':id', client_id);

                    $("#update_client_id").val(client_id);
                    $("#update_client_name").val(client_name);
                    $("#update_client_email").val(client_email);
                    $("#update_password").val(client_password);
                    $('#editEventForm').attr('action',url );
                });
                $(".delete-client-btn").click(function(e) {
                    e.preventDefault();
                    var user_id = $(this).data('user_id');
                    var url = '{{ route('provider.dashboard.clients.delete', ':id') }}';
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
