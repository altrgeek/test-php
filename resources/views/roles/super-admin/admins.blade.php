<x-app>

    {{-- Alert response --}}
    <x-layout.alert />

    {{-- Header --}}
    <div class="nk-block">
        <div class="nk-block-between">
            {{-- Page title --}}
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Admins Management</h3>
            </div>
            {{-- Add resource action button --}}
            <div class="nk-block-head-content">
                <a class="btn btn-primary" data-toggle="modal" data-target="#addAdminModal">
                    <em class="icon ni ni-plus"></em>
                    <span>Add Admin</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Records table --}}
    <div class="mt-5 card card-preview">
        <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false"
            id="Admin_Accounts_DataTable" aria-describedby="Admin_Accounts_DataTable_info">
            <thead>
                <tr>
                    <th class="nk-tb-col sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable" rowspan="1"
                        colspan="1" aria-label="User: activate to sort column ascending">
                        <span class="sub-text">Business Name</span>
                    </th>
                    <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">
                        <span class="sub-text">Business Email</span>
                    </th>
                    <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">
                        <span class="sub-text">Address</span>
                    </th>
                    <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                        <span class="sub-text">Date of birth</span>
                    </th>
                    <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Last Login: activate to sort column ascending">
                        <span class="sub-text">Phone number</span>
                    </th>
                    <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="Admin_Accounts_DataTable"
                        rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">
                        <span class="sub-text">Gender</span>
                    </th>
                    <th class="text-right nk-tb-col nk-tb-col-tools sorting" tabindex="0"
                        aria-controls="Admin_Accounts_DataTable" rowspan="1" colspan="1"
                        aria-label=" activate to sort column ascending">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                    <tr class="nk-tb-item odd">
                        <td class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-info">
                                    <span class="tb-lead">{{ $admin->name }} <span
                                            class="ml-1 dot dot-success d-md-none"></span></span>
                                </div>
                            </div>
                        </td>
                        <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                            <span class="tb-amount">{{ $admin->email }}</span>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <span>
                                {{ $admin->address ?? 'Not added yet' }}
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                {{ $admin->dob ?? 'Not added yet' }}
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                {{ $admin->phone ?? 'Not added yet' }}
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <span>
                                {{ $admin->gender ?? 'Not choosen yet' }}
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
                                                {{-- Update admin action --}}
                                                <li>
                                                    <a class="edit-user-btn" data-toggle="modal"
                                                        data-target="#updateAdminModal"
                                                        data-client_id="{{ $admin->admin_id }}"
                                                        data-client_segment="{{ $admin->segment }}"
                                                        data-client_name="{{ $admin->name }}"
                                                        data-client_email="{{ $admin->email }}">
                                                        <em class="icon ni ni-edit-alt"></em>
                                                        <span>Edit Admin</span>
                                                    </a>
                                                </li>
                                                {{-- Delete admin action --}}
                                                <li>
                                                    <a data-user_id="{{ $admin->admin_id }}" class="delete-client-btn">
                                                        <em class="icon ni ni-cross-circle"></em>
                                                        <span>Delete Admin</span>
                                                    </a>
                                                </li>
                                                {{-- Chat admin action --}}
                                                <li>
                                                    <a href="#" class="chat-client-btn">
                                                        <em class="icon ni ni-mail"></em>
                                                        <span>Start Chat</span>
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
        <div class="modal fade" id="addAdminModal">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    {{-- Modal Header --}}
                    <div class="modal-header">
                        <h5 class="modal-title">Create Admin</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>

                    {{-- Modal Content --}}
                    <div class="modal-body">
                        <form action="{{ route('super_admin.dashboard.admins.create') }}"
                            class="form-validate is-alter" method="POST">
                            @csrf

                            <div id="errors">
                            </div>

                            <div class="row gx-4 gy-3">
                                {{-- Business name --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_name">Business Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="business_name"
                                                id="name" placeholder="Enter business name" required />
                                        </div>
                                    </div>
                                </div>
                                {{-- Business website --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_name">Business Website Link</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="business_website"
                                                id="name" placeholder="Enter business website link"  />
                                        </div>
                                    </div>
                                </div>

                                {{-- Contact person name --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_name">
                                            Admin Full Name
                                        </label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="admin_name"
                                                id="name" placeholder="Enter full name" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Email address --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_email">Business Email</label>
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control" name="email"
                                                id="email-address" placeholder="Enter business email address"
                                                required />
                                        </div>
                                    </div>
                                </div>
                                {{-- Segment --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="segment">Select a subscription </label>
                                        <div class="form-control-wrap">
                                            <select name="segment" class="select-calendar-theme form-control"
                                                data-search="on">
                                                <option hidden selected disabled>Select Subscription</option>
                                                @foreach ($subscriptions as $subscription)
                                                    <option value="{{ $subscription->id }}">{{ $subscription->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- Segment --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="segment">Type of service </label>
                                        <div class="form-control-wrap">
                                            <select name="segment" class="select-calendar-theme form-control"
                                                data-search="on">
                                                <option hidden selected disabled>Select Segment</option>
                                                @foreach ($segments as $segment => $description)
                                                    <option value="{{ $segment }}">{{ $description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Segment --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="segment">Types of clients </label>
                                        <div class="form-control-wrap">
                                            <select  class="form-select js-select2 select2-hidden-accessible" multiple=""
                                            data-placeholder="Select clinet type" data-maximum-selection-length="3" data-select2-id="9" tabindex="-1"
                                            aria-hidden="true">
                                                {{-- @foreach ($segments as $segment => $description) --}}
                                                    <option value="Youths 14-25 ">Youths 14-25</option>
                                                    <option value="Young Adults 25-35 ">Young Adults 25-35 </option>
                                                    <option value="Adults 35-55 ">Adults 35-55 </option>
                                                    <option value="Seniors 55+">Seniors 55+</option>
                                                    <option value="BIPOC – LGBTQ+ ">BIPOC – LGBTQ+ </option>
                                                    <option value="Special needs ">Special needs </option>
                                                    <option value="Others">Others </option>
                                                {{-- @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                                      {{-- Segment --}}
                                                      <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="segment">Service provided  </label>
                                                            <div class="form-control-wrap">
                                                                <select  class="form-select js-select2 select2-hidden-accessible" multiple=""
                                                                data-placeholder="Select Service provided" data-maximum-selection-length="3" data-select2-id="10" tabindex="-1"
                                                                aria-hidden="true">
                                                                    {{-- @foreach ($segments as $segment => $description) --}}
                                                                        <option value="Assessment">Assessment</option>
                                                                        <option value="Self-guided workshops & exercises ">Self-guided workshops & exercises</option>
                                                                        <option value="Individual therapy">Individual therapy</option>
                                                                        <option value="Diagnosis testing">Diagnosis testing </option>
                                                                        <option value="Anxiety & stress">Anxiety & stress</option>
                                                                        <option value="Depression">Depression</option>
                                                                        <option value="Substance abuse">Substance abuse  </option>
                                                                        <option value="Trauma">Trauma</option>
                                                                        <option value="ADHD &Learning">ADHD &Learning   </option>
                                                                        <option value="Special needs">Special needs  </option>
                                                                        <option value="School Counseling & training">School Counseling & training   </option>
                                                                        <option value="Group therapy">Group therapy  </option>
                                                                        <option value="Family therapy">Family therapy </option>
                                                                        <option value="Support groups">Support groups</option>
                                                                        <option value="Specialized therapy">Specialized therapy  </option>
                                                                        <option value="Psychiatric & Diagnosis">Psychiatric & Diagnosis  </option>
                                                                    {{-- @endforeach --}}
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                              

                                {{-- Password --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_password">Temporary Password</label>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control" name="password"
                                                id="password" placeholder="Enter team password" required />
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
                        <form action="{{ route('super_admin.dashboard.admins.update', ':id') }}" id="editEventForm"
                            enctype="multipart/form-data" class="form-validate is-alter" novalidate="novalidate"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <input hidden name="id" id="update_client_id">
                            <div class="row gx-4 gy-3">
                                {{-- Business name --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_name">Business Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="update_client_name"
                                                name="name" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Business email --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_email">Business Email</label>
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control" id="update_client_email"
                                                name="email" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Team password --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="client_password">Temp Password</label>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control" name="update_password"
                                                id="client_password" />
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

        <form action="{{ route('super_admin.dashboard.admins.delete', ':id') }}" method="POST"
            id="deleteEventForm">
            @csrf
            @method('DELETE')
        </form>
    </x-slot>

    {{-- Additonal scripts for current page --}}
    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $(".edit-user-btn").click(function() {
                    let client_id = $(this).data('client_id');
                    let client_name = $(this).data('client_name');
                    let client_email = $(this).data('client_email');
                    let client_password = $(this).data('client_password');
                    let url = $('#editEventForm').attr('action');

                    url = url.replace(':id', client_id);
                    $("#update_client_id").val(client_id);
                    $("#update_client_name").val(client_name);
                    $("#update_client_email").val(client_email);
                    $("#update_password").val(client_password);
                    $('#editEventForm').attr('action', url);
                });
                $(".delete-client-btn").click(function(e) {
                    e.preventDefault();
                    var user_id = $(this).data('user_id');
                    var url = '{{ route('super_admin.dashboard.admins.delete', ':id') }}';
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
</x-app>
