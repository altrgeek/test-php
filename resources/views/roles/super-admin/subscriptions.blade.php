@php
    $options = Yaml::parseFile(resource_path('data/subscription.yaml'));
    $features = collect($options['features']['available']);
    $features = $features->map(fn (array $feature) => (object) $feature);
@endphp
<x-dashboard title="Subscription Management">
    <x-slot name="header">
        <x-dashboard.widgets.button label="Add Subscription" />
    </x-slot>

    {{-- Records table --}}
    <div class="mt-5 card card-preview">
        <table
            class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer"
            data-auto-responsive="false"
            id="Subscriptions_Management"
            aria-describedby="Subscriptions_Management_info"
        >
            <thead>
                <tr>
                    <th class="nk-tb-col sorting" tabindex="0" aria-controls="Subscriptions_Management" rowspan="1"
                        colspan="1" aria-label="Name: activate to sort column ascending">
                        <span class="sub-text">Name</span>
                    </th>
                    <th class="nk-tb-col tb-col-mb sorting" tabindex="0" aria-controls="Subscriptions_Management"
                        rowspan="1" colspan="1" aria-label="Description: activate to sort column ascending">
                        <span class="sub-text">Description</span>
                    </th>
                    <th class="nk-tb-col tb-col-md sorting" tabindex="0" aria-controls="Subscriptions_Management"
                        rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending">
                        <span class="sub-text">Price (USD)</span>
                    </th>
                    <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="Subscriptions_Management"
                        rowspan="1" colspan="1" aria-label="Duration: activate to sort column ascending">
                        <span class="sub-text">Duration</span>
                    </th>
                    <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="Subscriptions_Management"
                        rowspan="1" colspan="1" aria-label="Health Providers: activate to sort column ascending">
                        <span class="sub-text">Health Providers</span>
                    </th>
                    <th class="text-right nk-tb-col nk-tb-col-tools sorting" tabindex="0"
                        aria-controls="Subscriptions_Management" rowspan="1" colspan="1"
                        aria-label=" activate to sort column ascending">
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $subscription)
                    <tr class="nk-tb-item odd">
                        <td class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-info">
                                    <span class="tb-lead">{{ $subscription->name }} <span
                                            class="ml-1 dot dot-success d-md-none"></span></span>
                                </div>
                            </div>
                        </td>
                        <td class="nk-tb-col tb-col-mb">
                            <span class="tb-amount">{{ $subscription->description }}</span>
                        </td>
                        <td class="nk-tb-col tb-col-md">
                            <span>
                                {{ $subscription->price ?? 'Not added yet' }}
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                {{ $subscription->duration ?? 'Not added yet' }}
                            </span>
                        </td>
                        <td class="nk-tb-col tb-col-lg">
                            <span>
                                {{ $subscription->providers ?? 'Not added yet' }}
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
                                                        data-target="#updateSubscriptionModal"
                                                        data-subscription_id="{{ $subscription->id }}"
                                                        data-subscription_name="{{ $subscription->name }}"
                                                        data-subscription_description="{{ $subscription->description }}"
                                                        data-subscription_price="{{ $subscription->price }}"
                                                        data-subscription_duration="{{ $subscription->duration }}"
                                                        data-subscription_providers="{{ $subscription->providers }}"
                                                        data-subscription_features="{{ json_encode(Arr::get($subscription->meta, 'caps.available', [])) }}"
                                                    >
                                                        <em class="icon ni ni-edit-alt"></em>
                                                        <span>Edit Subscription</span>
                                                    </a>
                                                </li>
                                                {{-- Delete subscription action --}}
                                                <li>
                                                    <a data-subscription_id="{{ $subscription->id }}"
                                                        class="delete-client-btn">
                                                        <em class="icon ni ni-cross-circle"></em>
                                                        <span>Delete Subscription</span>
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
        <div class="modal fade" id="createResourceModal">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    {{-- Modal Header --}}
                    <div class="modal-header">
                        <h5 class="modal-title">Create Subscription</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>

                    {{-- Modal Content --}}
                    <div class="modal-body">
                        <form action="{{ route('super_admin.dashboard.subscriptions.create') }}"
                            class="form-validate is-alter" method="POST">
                            @csrf
                            <div class="row gx-4 gy-3">
                                {{-- Subscription name --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Subscription_name">
                                            Licensing Signing Officer
                                        </label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Enter name" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Subscription_description">Description</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="description"
                                                placeholder="Enter description" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- price --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Subscription_price">Price </label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="price"
                                            placeholder="Enter price" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Duration --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Subscription_duration">Duration</label>
                                        <div class="justify-around form-control-wrap d-flex">
                                            <div class="number-input">
                                                <input type="number" class="form-control" name="number"
                                                placeholder="Enter number" required />
                                            </div>
                                            <div class="duration-input">
                                                @php
                                                    $durations = [
                                                        'Days',
                                                        'Months',
                                                        'Years'
                                                    ];
                                                @endphp
                                                <select name="duration" class="form-control">
                                                    <option selected>Select a duration</option>
                                                    @foreach ($durations as $duration)
                                                        <option>{{ $duration }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Providers --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Subscription_providers">Providers</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="providers"
                                                placeholder="Enter providers" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Options available in subscriptions --}}
                                @if ($features->isNotEmpty())
                                    <div class="px-3 col-12">
                                        <p class="form-label">Licensing Packages</p>
                                        <div class="d-flex flex-column align-items-stretch">
                                            @foreach ($features as $feature)
                                                @php $__id = CStr::id('input_check') @endphp
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        name="{{ $feature->label }}"
                                                        id="{{ $__id }}"
                                                        class="form-check-input"
                                                        value="true"
                                                    />
                                                    <label class="form-check-label" for="{{ $__id }}">
                                                        {{ $feature->description }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

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
        <div class="modal fade" id="updateSubscriptionModal">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    {{-- Modal Header --}}
                    <div class="modal-header">
                        <h5 class="modal-title">Update Subsctiption</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    {{-- Modal Content --}}
                    <div class="modal-body">
                        <form action="{{ route('super_admin.dashboard.subscriptions.update', ':id') }}" id="editEventForm"
                            enctype="multipart/form-data" class="form-validate is-alter" novalidate="novalidate"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <input hidden name="subscription_id" id="update_subscription_id">
                            <div class="row gx-4 gy-3">

                                {{-- Subscription name --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Subscription_name">
                                            Licensing Signing Officer
                                        </label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="name" id="update_subscription_name"
                                                placeholder="Enter name" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Subscription_description">Description</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="description" id="update_subscription_description"
                                                placeholder="Enter description" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- price --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Subscription_price">Price </label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="price" id="update_subscription_price"
                                            placeholder="Enter price" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Duration --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Subscription_duration">Duration</label>
                                        <div class="justify-around form-control-wrap d-flex">
                                            <div class="number_input">
                                                <input type="datetime" class="form-control" name="number" id="update_subscription_duration_number"
                                                placeholder="Enter duration" required />
                                            </div>
                                            <div class="duration_input">
                                                {{-- <input type="datetime" class="form-control" name="duration" id="update_subscription_duration"
                                                placeholder="Enter days/months or years" required /> --}}
                                                <select name="duration" class="form-control" id="update_subscription_duration">
                                                    <option selected>Select a duration</option>
                                                    @foreach ($durations as $duration)
                                                        <option>{{ $duration }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Providers --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="Subscription_providers">Providers</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="providers" id="update_subscription_providers"
                                                placeholder="Enter providers" required />
                                        </div>
                                    </div>
                                </div>

                                {{-- Options available in subscriptions --}}
                                @if ($features->isNotEmpty())
                                    <div class="px-3 col-12">
                                        <p class="form-label">Licensing Packages</p>
                                        <div class="d-flex flex-column align-items-stretch">
                                            @foreach ($features as $feature)
                                                @php
                                                    $__id = sprintf('update_subscription_%s', $feature->label);
                                                @endphp
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        name="{{ $feature->label }}"
                                                        id="{{ $__id }}"
                                                        class="form-check-input"
                                                        value="true"
                                                    />
                                                    <label class="form-check-label" for="{{ $__id }}">
                                                        {{ $feature->description }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

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

        <form action="{{ route('super_admin.dashboard.subscriptions.delete', ':id') }}" method="POST" id="deleteEventForm">
            @csrf
            @method('DELETE')
        </form>
    </x-slot>

    {{-- Additonal scripts for current page --}}
    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $(".edit-user-btn").click(function() {
                    let subscription_id = $(this).data('subscription_id');
                    let subscription_name = $(this).data('subscription_name');
                    let subscription_description = $(this).data('subscription_description');
                    let subscription_price = $(this).data('subscription_price');
                    let subscription_duration = $(this).data('subscription_duration');
                    let subscription_providers = $(this).data('subscription_providers');
                    let subscription_features = $(this).data('subscription_features');
                    let url = $('#editEventForm').attr('action');

                    console.log({subscription_features});

                    // splits and removes the "-" from string and adds white space
                    const string = subscription_duration.split("-").join(' ');

                    const duration_number = string.split(" ", 1);

                    const duration = string.split(" ", 2);
                    const features = {!! $features->map(fn ($feature) => $feature->label)->toJson() !!}
                    console.log({features})

                    for (let feature of features) {
                        const __id = `update_subscription_${feature}`;
                        const elem = $(`#${__id}`);
                        console.log({__id, elem, includes: subscription_features.includes(feature)})
                        elem.prop('checked', subscription_features.includes(feature)).change()
                    }

                    url = url.replace(':id', subscription_id);
                    $("#update_subscription_id").val(subscription_id);
                    $("#update_subscription_name").val(subscription_name);
                    $("#update_subscription_description").val(subscription_description);
                    $("#update_subscription_price").val(subscription_price);
                    $("#update_subscription_duration_number").val(duration_number);
                    $("#update_subscription_duration").val(duration);
                    $("#update_subscription_providers").val(subscription_providers);
                    $('#editEventForm').attr('action', url);
                });
                $(".delete-client-btn").click(function(e) {
                    e.preventDefault();
                    var user_id = $(this).data('subscription_id');
                    var url = '{{ route('super_admin.dashboard.subscriptions.delete', ':id') }}';
                    url = url.replace(':id', user_id);

                    Swal.fire({
                        title: 'Are you sure you want to delete?',
                        text: 'The subscription will be deleted!',
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
