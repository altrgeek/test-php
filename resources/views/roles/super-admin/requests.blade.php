<x-app>
    <div class="nk-block">
        <div class="col-12 div_alert">
            @include('layouts.alerts')
        </div>
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">All Clients </h3>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addclient"><em
                        class="icon ni ni-plus"></em><span>Add Client</span></a>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="card card-preview mt-5">
        <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false"
            id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info">
            <thead>
                <tr>
                    <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1"
                        colspan="1" aria-label="User: activate to sort column ascending">
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
                    <th class="nk-tb-col nk-tb-col-tools text-right sorting" tabindex="0"
                        aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                        aria-label=" activate to sort column ascending">
                    </th>
                </tr>
            </thead>
            <tbody>
                <!-- .nk-tb-item  -->
                <!-- .nk-tb-item  -->
                <!-- .nk-tb-item  -->
                @foreach ($clients as $client)
                    <tr class="nk-tb-item odd">
                        <td class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-info">
                                    <span class="tb-lead">{{ $client->name }} <span
                                            class="dot dot-success d-md-none ml-1"></span></span>

                                </div>
                            </div>
                        </td>
                        <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                            <span class="tb-amount">{{ $client->email }}</span>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <span>
                                @if ($client->address)
                                    {{ $client->address }}
                                @else
                                    {{ 'Not Added Yet' }}
                                @endif
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                @if ($client->DOB)
                                    {{ $client->DOB }}
                                @else
                                    {{ 'Not Added Yet' }}
                                @endif
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                @if ($client->phone)
                                    {{ $client->phone }}
                                @else
                                    {{ 'Not Added Yet' }}
                                @endif
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <span>
                                @if ($client->gender)
                                    {{ $client->gender }}
                                @else
                                    {{ 'Not Added Yet' }}
                                @endif
                            </span>
                        </td>
                        <td class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                            data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="link-list-opt no-bdr">
                                                {{-- <li><a href="#"><em class="icon ni ni-edit-alt"></em><span>Edit User</span></a></li> --}}
                                                <li><a class="edit-user-btn" data-toggle="modal"
                                                        data-target="#updateclient"
                                                        data-client_id="{{ $client->user->id }}"
                                                        data-client_name="{{ $client->user->name }}"
                                                        data-client_email="{{ $client->user->email }}"
                                                        data-client_password="{{ $client->user->password }}"><em
                                                            class="icon ni ni-edit-alt"></em><span>Update
                                                            User</span></a></li>
                                                <li><a data-user_id="{{ $client->user_id }}"
                                                        class="delete-client-btn"><em
                                                            class="icon ni ni-cross-circle"></em><span>Delete
                                                            User</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach


        </table>
    </div>

    <x-slot name="modals">
        <!-- Add Client Modal -->
        <div class="modal fade" id="addclient">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Client</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('super_admin_dashboard.addClients.store') }}" id="addEventForm"
                            enctype="multipart/form-data" class="form-validate is-alter" novalidate="novalidate"
                            method="POST">
                            @csrf
                            <div class="row gx-4 gy-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_name">Client Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="client_name" name="name"
                                                placeholder="Enter Client Name " required>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_email">Client Email</label>
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control" id="client_email" name="email"
                                                placeholder="Enter Client Email" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_password">Client Password</label>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control" name="password"
                                                id="client_password" placeholder="Enter Temporary Password" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <button id="addEvent" type="submit" class="btn btn-primary">Create</button>
                                    </div>

                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Client Modal -->
        <div class="modal fade" id="updateclient">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Client</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('super_admin_dashboard.addClients.update') }}" id="addEventForm"
                            enctype="multipart/form-data" class="form-validate is-alter" novalidate="novalidate"
                            method="POST">
                            @csrf
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
                                                id="client_password" required>
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


    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $(".edit-user-btn").click(function() {
                    let client_id = $(this).data('client_id');
                    let client_name = $(this).data('client_name');
                    let client_email = $(this).data('client_email');
                    let client_password = $(this).data('client_password');

                    $("#update_client_id").val(client_id);
                    $("#update_client_name").val(client_name);
                    $("#update_client_email").val(client_email);
                    $("#update_password").val(client_password);
                });
                $(".delete-client-btn").click(function(e) {
                    e.preventDefault();
                    var user_id = $(this).data('user_id');
                    var url = '{{ route('super_admin_dashboard.Clients.delete', ':id') }}';
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
                            window.location = url;
                        }
                    });
                });

            });
        </script>
    </x-slot>
</x-app>
@endsection

@push('scripts')
@endpush
