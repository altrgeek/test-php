<x-dashboard title="COGNI® Self-Guided Therapy and Experiential Training Exercises">
    @if (isset($can_create) && $can_create)
        <x-slot name="header">
            <div class="d-flex justify-content-end align-items-center">
                @if ($user->isSuperAdmin())
                    <x-dashboard.widgets.button
                        for="none"
                        class="mr-2"
                        icon="edit"
                        label="All Therapies"
                        href="{{ route('super_admin.dashboard.marketplace') }}"
                    />
                @endif
                @if ($user->isSuperAdmin() || $user->isAdmin() || $user->isProvider())
                    <x-dashboard.widgets.button label="Add Self-Guided Therapy" />
                @endif
            </div>
        </x-slot>
    @endif

    <table class="datatable-init nk-tb-list nk-tb-ulist dataTable no-footer">
        <thead>
            <tr>
                <th class="nk-tb-col sorting">
                    <span class="sub-text">Image</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Title</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Description and Objective</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Method</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Material and Equipment</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Treatments</span>
                </th>

                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Duration</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Provider</span>
                </th>
                <th class="nk-tb-col nk-tb-col-tools"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($therapies as $therapy)
                <tr class="nk-tb-item {{ $loop->even ? 'even' : 'odd' }}">
                    <td class="nk-tb-col">
                        <span>
                            <img src="{{ $therapy->image }}" width="150px" height="auto" alt="" >
                        </span>
                    <td class="nk-tb-col">
                        <span>{{ $therapy->title }}</span>
                    </td>
                    <td class="nk-tb-col">
                        <span>{{ $therapy->description }}</span>
                    </td>
                    <td class="nk-tb-col">
                        <span>{{ $therapy->method }}</span>
                    </td>
                    <td class="nk-tb-col">
                        <span>{{ $therapy->material }}</span>
                    </td>

                    

                    <td class="nk-tb-col">
                        @foreach ($therapy->marketplaces as $option)
                            <a
                                href="{{ $option->url }}"
                                target="_blank"
                                class="badge bg-lighter"
                            >
                                {{ $option->name }}

                    </a>
                    @endforeach
                    </td>
                    <td class="nk-tb-col">
                        <span>{{ $therapy->duration }}</span>
                    </td>
                    <td class="nk-tb-col">
                        <span>{{ $user->name }}</span>
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
                                    data-resource="{{ $therapy->toJson() }}"
                                >
                                    <!-- Details -->
                                    <li>
                                        <a
                                            href="#"
                                            data-toggle="modal"
                                            data-target="#previewResourceModal"
                                            onclick="populateFields(this)"
                                        >
                                            <em class="icon ni ni-eye"></em>
                                            <span>View Details</span>
                                        </a>
                                    </li>
                                    @role('provider')
                                    <li>
                                        <a
                                            href="{{ route('provider.show-to-do-list',$therapy->id) }}"
                                            
                                        >
                                            <em class="icon ni ni-cc-new"></em>
                                            <span>ToDo List</span>
                                        </a>
                                    </li>
                                    @endrole
                                    @can('update', $therapy)
                                        <li>
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#editResourceModal"
                                                onclick="populateFields(this)"
                                            >
                                                <em class="icon ni ni-edit"></em>
                                                <span>Edit</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('delete', $therapy)
                                        <li>
                                            <a
                                                href="#"
                                                data-toggle="modal"
                                                data-target="#deleteResourceModal"
                                                onclick="populateFields(this)"
                                            >
                                                <em class="icon ni ni-trash"></em>
                                                <span>Delete</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    </td>
                        
                    </td>
                   

                    
                </tr>
            @endforeach
        </tbody>
    </table>

    <x-slot name="modals">
        <!-- Preview therapy details modal -->
        <x-dashboard.widgets.modal
            title="VR Therapy Details"
            id="preview"
        >

        <!-- Therapy image -->
        <div class="form-group col-12">
            <span class="form-label">Image</span>
            <div class="form-control-wrap">
                <img src="" width="150px" height="auto" alt="" id="previewTherapyImageField"  >
                
            </div>
        </div>

            <!-- Therapy Name -->
            <div class="form-group col-12">
                <span class="form-label">Title</span>
                <div class="form-control-wrap">
                    <span id="previewTherapyNameField"></span>
                </div>
            </div>

            <!-- Therapy Description -->
            <div class="form-group col-12">
                <span class="form-label">Description and Objectives</span>
                <div class="form-control-wrap">
                    <span id="previewTherapyDescriptionField"></span>
                </div>
            </div>

            <!--Therapy materials and equipment-->
            <div class="form-group col-12">
                <span class="form-label">Material and Equipment</span>
                <div class="form-control-wrap">
                    <span id="previewTherapyMaterialField"></span>
                </div>
            </div>

            <!--Therapy mehtod-->
            <div class="form-group col-12">
                <span class="form-label">Method</span>
                <div class="form-control-wrap">
                    <span id="previewTherapyMethodField"></span>
                </div>
            </div>

            <!-- Therapy Timing -->
            <div class="form-group col-12">
                <span class="form-label">Timing</span>
                <div class="form-control-wrap">
                    <span id="previewTherapyTimingField"></span>
                </div>
            </div>

            <!-- Therapy Marketplace Options -->
            <div class="form-group col-12">
                <span class="form-label">Marketplace Options</span>
                <div class="form-control-wrap">
                    <span id="previewTherapyMarketplacesWrapper"></span>
                </div>
            </div>

            <!-- Therapy Provider -->
            <div class="form-group col-12">
                <span class="form-label">Provider</span>
                <div class="form-control-wrap">
                    <span id="previewTherapyProviderField"></span>
                </div>
            </div>
        </x-dashboard.widgets.modal>

        <!-- Create VR therapy modal -->
        <x-dashboard.widgets.modal
            title="Add VR Therapy"
            :url="route('dashboard.vr-therapies.create')"
        >
            @production
                @php
                    $__defaults = [
                        'title'        => old('title'),
                        'description' => old('description'),
                        'method' => old('method'),
                        'duration' => old('duration'),
                        'material' => old('material'),
                    ];
                @endphp
            @else
                @php
                    $faker = Faker\Factory::create();
                    $__defaults = [
                        'title'        => ucfirst($faker->words(random_int(2, 4), true)),
                        'description' => ucfirst($faker->sentences(random_int(2, 5), true)),
                        'method' => ucfirst($faker->sentences(random_int(2,5),true)),
                        'duration'      => time(),
                        'material'   => ucfirst($faker->sentences(random_int(2,5),true)),
                        'image'      => $faker->imageUrl(640, 480, 'technics', true),
                        
                    ];
                @endphp
            @endproduction
        
            <!-- Therapy Name -->
            <x-dashboard.widgets.form.input
                label="Title"
                name="title"
                id="therapyName"
                value="{{ $__defaults['title'] }}"
                placeholder="Enter therapy name"
                required
            />

            <!-- Therapy Image -->
            <x-dashboard.widgets.form.input
                label="Image"
                type="file"
                name="image"
                id="therapyImage"
                placeholder="Upload therapy image"
                accept="image/*"
                
            />

            <!-- Therapy Description -->
            <x-dashboard.widgets.form.input
                label="Objective and Description"
                type="textarea"
                name="description"
                id="therapyDescription"
                placeholder="Enter therapy description"
                required
            >{!! $__defaults['description'] !!}</x-dashboard.widgets.form.input>

            <!-- Material and Equipment -->
            <x-dashboard.widgets.form.input
                label="Material and Equipment"
                type="textarea"
                name="material"
                id="therapyMaterial"
                placeholder="Enter therapy material"
                required
            >{!! $__defaults['material'] !!}</x-dashboard.widgets.form.input>

            <!--method-->
            <x-dashboard.widgets.form.input
                label="Method"
                type="textarea"
                name="method"
                id="therapyMethod"
                placeholder="Enter therapy method"
                required
            >{!! $__defaults['method'] !!}</x-dashboard.widgets.form.input>

            <!-- Therapy Timing -->
            <x-dashboard.widgets.form.input
                label="Duration"
                name="duration"
                id="therapyTiming"
                type='time'
                value="{{ $__defaults['duration'] }}"
                placeholder="Enter therapy timing"
                required
            />

            <!-- Marketplace options -->
            <x-dashboard.widgets.form.select
                label="Treatments"
                name="marketplaces[]"
                multiple="multiple"
                multiple="multiple"
                id="therapyMarketplace"
            >
                @foreach ($marketplaces as $option)
                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                @endforeach
            </x-dashboard.widgets.form.select>

            <!-- If is super admin then group providers by admin -->
            @if ($user->isSuperAdmin())
                <x-dashboard.widgets.form.select
                    label="Provider"
                    name="provider_id"
                    id="therapyProviderId"
                    required
                >
                    @foreach ($admins as $admin)
                        <optgroup label="{{ $admin->user->name }}">
                            @foreach ($admin->providers as $provider)
                                <option value="{{ $provider->id }}">
                                    {{ $provider->user->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </x-dashboard.widgets.form.select>
            @endif

            <!-- If is admin then only show their providers -->
            @if ($user->isAdmin())
                <x-dashboard.widgets.form.select
                    label="Provider"
                    name="provider_id"
                    id="therapyProviderId"
                    required
                >
                    @foreach ($providers as $provider)
                        <option value="{{ $provider->id }}">
                            {{ $provider->user->name }}
                        </option>
                    @endforeach
                </x-dashboard.widgets.form.select>
            @endif
        </x-dashboard.widgets.modal>

        <!-- Edit VR therapy modal -->
        <x-dashboard.widgets.modal
            title="Edit VR Therapy"
            :url="route('dashboard.vr-therapies.update', ':id')"
            method="PUT"
            action="Update"
            id="edit"
        >
            <!-- Therapy Name -->
            <x-dashboard.widgets.form.input
                label="Title"
                name="title"
                id="editTherapyName"
                value=""
                placeholder="Enter therapy name"
                required
            />

            <!--Therapy image-->
            <x-dashboard.widgets.form.input
                label="Image"
                type="file"
                name="image"
                id="editTherapyImage"
                placeholder="Upload therapy image"
                accept="image/*"
                required
            />

            <!-- Therapy Description -->
            <x-dashboard.widgets.form.input
                label="Objective and Description"
                name="description"
                type="textarea"
                id="editTherapyDescriptions"
                value=""
                placeholder="Enter therapy description"
                required
            />
        <!--material and equipment-->
            <x-dashboard.widgets.form.input
                label="Material and Equipment"
                type="textarea"
                name="material"
                value=""
                id="editTherapyMaterial"
                placeholder="Enter therapy material"
                required
            />


            <!--method-->
            <x-dashboard.widgets.form.input
                label="Method"
                type="textarea"
                name="method"
                id="editTherapyMethod"
                placeholder="Enter therapy method"
                required
            />  

            <!-- Therapy Timing -->
            <x-dashboard.widgets.form.input
                label="Duration"
                name="duration"
                type="time"
                id="editTherapyTiming"
                value=""
                placeholder="Enter therapy timing"
                required
            />

            <!-- Marketplace options -->
            <x-dashboard.widgets.form.select
                label="Treatments"
                name="marketplaces[]"
                multiple="multiple"
                multiple="multiple"
                id="editTherapyMarketplace"
            >
                @foreach ($marketplaces as $option)
                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                @endforeach
            </x-dashboard.widgets.form.select>

            <!-- If is super admin then group providers by admin -->
            @if ($user->isSuperAdmin())
                <x-dashboard.widgets.form.select
                    label="Provider"
                    name="provider_id"
                    id="editTherapyProviderId"
                    required
                >
                    @foreach ($admins as $admin)
                        <optgroup label="{{ $admin->user->name }}">
                            @foreach ($admin->providers as $provider)
                                <option value="{{ $provider->id }}">
                                    {{ $provider->user->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </x-dashboard.widgets.form.select>
            @endif

            <!-- If is admin then only show their providers -->
            @if ($user->isAdmin())
                <x-dashboard.widgets.form.select
                    label="Provider"
                    name="provider_id"
                    id="editTherapyProviderId"
                    required
                >
                    @foreach ($providers as $provider)
                        <option value="{{ $provider->id }}">
                            {{ $provider->user->name }}
                        </option>
                    @endforeach
                </x-dashboard.widgets.form.select>
            @endif
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
            const populateFields = (that) => {
                const therapy = $(that).parent().parent().data('resource');
                const {id, title, method,material,description, duration,image} = therapy
                const {marketplaces, provider} = therapy
                

                const editUrl = $('#editResourceModalForm').attr('action');
                const deleteUrl = $('#deleteResourceModalForm').attr('action');

                if (editUrl) $('#editResourceModalForm').attr('action', editUrl.replace(':id', id));
                if (deleteUrl) $('#deleteResourceModalForm').attr('action', deleteUrl.replace(':id', id));

                // const prettyTiming = moment(timing).format('ddd, Do MMMM YYYY');

                const handleMultiSelect = (id, items) => {
                    const elem = document.getElementById(id)
                    const values = items.map(({id}) => id.toString());
                    if (! elem || ! elem.options) return;
                    for (let i = 0; i < elem.options.length; i++)
                        elem.options[i].selected = values.indexOf(elem.options[i].value) > -1;
                }

                const addMarketplaceBadges = (marketplaces) => {
                    const items = [];

                    marketplaces.forEach(({name, url}) => {
                        const item = $('<a></a>')
                            .addClass('badge bg-lighter mr-1 mb-1')
                            .attr('href', url)
                            .attr('target', '_blank')
                            .text(name);

                        items.push(item);
                    })

                    $('#previewTherapyMarketplacesWrapper').html(items);
                }

                newImgUrl = 'http://127.0.0.1:8000/storage/app/'+image
                console.log(image);

                $('#previewTherapyNameField').text(title)
                $('#previewTherapyMethodField').text(method);
                $('#previewTherapyMaterialField').text(material);
                $('#previewTherapyImageField').attr('src', image );
                $('#previewTherapyDescriptionField').text(description)
                $('#previewTherapyTimingField').text(duration)
                $('#previewTherapyProviderField').text(provider.user.name)
                addMarketplaceBadges(marketplaces)

                
                
                $('#editTherapyNameInputField').val(title)
                $('#editTherapyMaterialTextareaField').val(material)
                $('#editTherapyMethodTextareaField').val(method)
                $('#editTherapyTimingInputField').val(duration)
                $('#editTherapyDescriptionsTextareaField').val(description)
                
                
                
                $('#editTherapyProviderSelectField').val(provider.id)
                handleMultiSelect('editTherapyMarketplaceSelectField', marketplaces);
                
            }
        </script>
    </x-slot>
</x-dashboard>
