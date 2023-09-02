<x-dashboard title="ToDo List">  

    <x-slot name="header">
            <div class="d-flex justify-content-end align-items-center">
                @role ('super_admin')
                    <x-dashboard.widgets.button label="Add ToDo List" />
                @endrole
            </div>
        </x-slot>


    <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer">
        <thead>
            <tr>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Title</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Description</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Start</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Duration</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Admin Name</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Admin Email</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">End</span>
                </th>
                <th class="nk-tb-col nk-tb-col-tools"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listings as $listing )
                <tr>
                    <td>
                        {{ $listing->title }}
                    </td>
                    <td>
                        {{ $listing->description }}
                    </td>
                    <td>
                        {{ $listing->start }}
                    </td>
                    <td>
                        {{ $listing->duration." ".$listing->unit }}
                    </td>
                    <td>
                        <a class="badge bg-lighter">{{ $clients[$listing->assigned_to_id]['name'] }}</a>
                    </td>
                    <td>
                        <a class="badge bg-lighter">{{ $clients[$listing->assigned_to_id]['email'] }}</a>
                    </td>
                    <td>
                        {{ $listing->end}}
                    </td>
                    <td class="nk-tb-col nk-tb-col-tools">
                        <div class="drodown">
                            <a
                                href="#"
                                class="dropdown-toggle btn btn-icon btn-trigger"
                                data-toggle="dropdown"
                            >
                                <em class="icon ni ni-more-v"></em>
                            </a>

                            <!-- Content -->
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul
                                    class="link-list-opt no-bdr"
                                    data-resource="{{ $listing->toJson() }}"
                                >
                                        <li>
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#previewResourceModal"
                                                onclick="populateFields({{ $listing->toJson()}}, '{{ $clients[$listing->assigned_to_id]['name'] }}','{{ $clients[$listing->assigned_to_id]['email'] }}' )"

                                            >
                                                <em class="icon ni ni-eye"></em>
                                                <span>View</span>
                                            </a>
                                        </li>
                                </ul>
                                <ul
                                    class="link-list-opt no-bdr"
                                    data-resource="{{ $listing->toJson() }}"
                                >
                                        <li>
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#editResourceModal"
                                                onclick="populateFields({{ $listing->toJson() }})"
                                            >
                                                <em class="icon ni ni-edit"></em>
                                                <span>Edit</span>
                                            </a>
                                        </li>
                                </ul>
                                <ul class="link-list-opt no-bdr">
                                    <li>
                                        <a
                                                href="{{ route('dashboard.delete',$listing->id) }}"
                                            >
                                                <em class="icon ni ni-trash"></em>
                                                <span>Delete</span>
                                            </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>    
            @endforeach
           
        </tbody>
    </table>

    <x-slot name="modals">
        <!-- Preview therapy details modal -->
        <x-dashboard.widgets.modal
            title="TODO list Details"
            id="preview"
        >

        <!-- Therapy image -->
        <div class="form-group col-12">
            <span class="form-label">Title</span>
            <div class="form-control-wrap">
                <span src="" width="150px" height="auto" alt="" id="previewtodotitle"  >
            </div>
        </div>

            <!-- Therapy Name -->
            <div class="form-group col-12">
                <span class="form-label">Description</span>
                <div class="form-control-wrap">
                    <span id="previewtododescription"></span>
                </div>
            </div>

            <!-- Therapy Description -->
            <div class="form-group col-12">
                <span class="form-label">Start Date</span>
                <div class="form-control-wrap">
                    <span id="previewtodostart"></span>
                </div>
            </div>

            <!--Therapy materials and equipment-->
            <div class="form-group col-12">
                <span class="form-label">Duration</span>
                <div class="form-control-wrap">
                    <span id="previewtododuration"></span>
                </div>
            </div>

            <!--Therapy mehtod-->
            <div class="form-group col-12">
                <span class="form-label">Provider Name</span>
                <div class="form-control-wrap">
                    <span id="previewtodoprovidername"></span>
                </div>
            </div>

            <!-- Therapy Timing -->
            <div class="form-group col-12">
                <span class="form-label">Provider Email</span>
                <div class="form-control-wrap">
                    <span id="previewtodoprovideremail"></span>
                </div>
            </div>

            <!-- Therapy Marketplace Options -->
            <div class="form-group col-12">
                <span class="form-label">End Date</span>
                <div class="form-control-wrap">
                    <span id="previewtodoend"></span>
                </div>
            </div>

            
        </x-dashboard.widgets.modal>

        <!-- Create VR therapy modal -->
        <x-dashboard.widgets.modal
            title="Add ToDo Listing"
            :url="route('dashboard.storeListing')"
        >
            @production
                @php
                    $__defaults = [
                        'title'        => old('title'),
                        'description' => old('description'),
                        'duration' => old('duration'),
                        'start' => old('start'),
                    ];
                @endphp
            @else
                @php
                    $faker = Faker\Factory::create();
                    $__defaults = [
                        'title'        => ucfirst($faker->words(random_int(2, 4), true)),
                        'description' => ucfirst($faker->sentences(random_int(2, 5), true)),
                        'duration'      => time(),
                        'start'   => ucfirst($faker->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d H:i:s')),
                        
                    ];
                @endphp
            @endproduction
        
            <!-- Therapy Name -->
            <x-dashboard.widgets.form.input
                label="Title"
                name="title"
                id="todotitle"
                value="{{ $__defaults['title'] }}"
                placeholder="Enter To Do Listing name"
                required
            />

            <!-- Therapy Description -->
            <x-dashboard.widgets.form.input
                label="Description"
                type="textarea"
                name="description"
                id="todoDescription"
                placeholder="Enter To Do Listing description"
                required
            >{!! $__defaults['description'] !!}</x-dashboard.widgets.form.input>

            <!-- Material and Equipment -->
            <x-dashboard.widgets.form.input
                label="Start Date"
                type="datetime-local"
                name="start"
                id="todoStart"
                placeholder="Enter To Do Listing Start Date"
                required
            >{!! $__defaults['start'] !!}</x-dashboard.widgets.form.input>


            <!-- Therapy Timing -->
            <x-dashboard.widgets.form.input
                label="Duration"
                name="duration"
                min='0'
                id="todoTiming"
                type='number'
                value=1
                required
            />
            <x-dashboard.widgets.form.select
                label="Duration Unit"
                name="unit"
                id="durationunit"
                required
            >
                <option value="minutes" default>Minutes</option>
                <option value="hours">Hours</option>
                <option value="days">Days</option>
                <option value="weeks">Weeks</option>
                <option value="months">Months</option>
                <option value="years">Years</option>
            </x-dashboard.widgets.form.select>

            <!-- Marketplace options -->
            <x-dashboard.widgets.form.select
                label="Admin"
                name="client_id"
                id="client_id"
            >
            @foreach ($clients as $index => $client)
            <option class="text-dark" value="{{ $index }}">{{ $client['name'] }}</option>
        @endforeach
        
            </x-dashboard.widgets.form.select>

            <input type="hidden" value={{ $user->id }} name='provider_id' id = 'provider_id'>
           
        </x-dashboard.widgets.modal>

        <!-- Edit VR therapy modal -->
        <x-dashboard.widgets.modal
            title="Edit ToDo Listing"
            :url="route('dashboard.editTodoListing')"
            method="PUT"
            action="Update"
            id="edit"
        >
            <!-- Therapy Name -->
            <x-dashboard.widgets.form.input
                label="Title"
                name="title"
                id="editListingName"
                value=""
                placeholder="Enter ToDo Listing title"
                required
            />

            <!-- Therapy Description -->
            <x-dashboard.widgets.form.input
                label="Description"
                name="description"
                type="textarea"
                id="editListingDescriptions"
                value=""
                placeholder="Enter ToDo Listing description"
                required
            />
        <!--material and equipment-->
            <x-dashboard.widgets.form.input
                label="Start Date"
                type="datetime-local"
                name="start"
                value=""
                id="editListingStartDate"
                required
            />

            <input type="hidden" value={{ $user->id }} name='provider_id' id = 'provider_id'>
            <input type="hidden" name="list_id" id="list_id">

            <!--method-->
            <x-dashboard.widgets.form.input
                label="Duration"
                type="number"
                name="duration"
                min=0
                value=2
                id="editListingDuration"
                placeholder="Enter ToDo Listing Duration"
                required
            />

            <x-dashboard.widgets.form.select
                label="Duration Unit"
                name="unit"
                id="editListingDurationUnit"
                required
            >
                <option value="minutes" default>Minutes</option>
                <option value="hours">Hours</option>
                <option value="days">Days</option>
                <option value="weeks">Weeks</option>
                <option value="months">Months</option>
                <option value="years">Years</option>
            </x-dashboard.widgets.form.select>

            <!-- Marketplace options -->
            <x-dashboard.widgets.form.select
                label="Admin"
                name="client_id"
                id="editListingClient"
            >
            @foreach ($clients as $index => $client)
            <option class="text-dark" value="{{ $index }}">{{ $client['name'] }}</option>
        @endforeach
        
            </x-dashboard.widgets.form.select>

          

           
        </x-dashboard.widgets.modal>

        <!-- Delete VR therapy modal -->
        <x-dashboard.widgets.modal
            title="Delete VR therapy"
            method="DELETE"
            :url="route('dashboard.vr-therapies.delete', ':id')"
            action="Delete"
            id="delete"
            noHeader
        >
            <h5 class="text-center col-12 my-5">
                Are you sure want to delete this therapy?
            </h5>
        </x-dashboard.widgets.modal>
    </x-slot>


    <x-slot name="scripts">
        <script
            type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"
        ></script>

        <script type="text/javascript">
            const populateFields = (that,name, email) => {
                console.log("this is"+that)
                const handleMultiSelect = (id, items) => {
                    const elem = document.getElementById(id)
                    const values = items.map(({id}) => id.toString());
                    if (! elem || ! elem.options) return;
                    for (let i = 0; i < elem.options.length; i++)
                        elem.options[i].selected = values.indexOf(elem.options[i].value) > -1;
                }

                console.log('title');
                console.log(that.title);
                
                $('#editListingNameInputField').val(that.title)
                $('#editListingDescriptionsTextareaField').val(that.description)
                $('#editListingStartDateInputField').val(that.start)
                $('#editListingDurationInputField').val(that.duration)
                $('#select2-editListingDurationUnitSelectField').val(that.unit);
                $('#select2-editListingClientSelectField').val(that.client_id);
                $('#editListingIdInputField').val(that.id)
                $('#list_id').val(that.id)

                //set innerhtml of previewtodotitle as that.title
                document.getElementById("previewtodotitle").innerHTML = that.title;
                document.getElementById("previewtododescription").innerHTML = that.description;
                document.getElementById("previewtodostart").innerHTML = that.start;
                document.getElementById("previewtodoend").innerHTML = that.end
                document.getElementById("previewtododuration").innerHTML = `${that.duration} ${that.unit}`
                document.getElementById("previewtodoprovidername").innerHTML = name
                document.getElementById("previewtodoprovideremail").innerHTML = email
                
                
            }
        </script>
    </x-slot>
</x-dashboard>
