<x-dashboard title="ToDo List For Group Therapy">  

    <x-slot name="header">
            <div class="d-flex justify-content-end align-items-center">
                @role ('provider')
                    <x-dashboard.widgets.button label="Add ToDo List Group" />
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
                    <span class="sub-text">Client Names</span>
                </th>
                <th class="nk-tb-col sorting" tabindex="0">
                    <span class="sub-text">Client Emails</span>
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
                    @foreach ($groups as $group)
                        @if ($group->to_do_list_id == $listing->id)
                            <a class="badge bg-lighter">{{ $clients[$group->client_id]['name']}}</a> 
                        @endif
                    @endforeach
                   </td>
                   <td>
                    @foreach ($groups as $group)
                        @if ($group->to_do_list_id == $listing->id)
                            <a class="badge bg-lighter">{{ $clients[$group->client_id]['email']}}</a> 
                        @endif 
                     @endforeach
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
                                                data-target="#editResourceModal"
                                                onclick="populateFields({{ $listing->toJson() }},{{ $groups->toJson() }},{{ $clients->toJson() }})"
                                            >
                                                <em class="icon ni ni-edit"></em>
                                                <span>Edit</span>
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
         title="Add ToDo Listing"
         :url="route('provider.storeGroup')"
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
         {{-- <input type="hidden" name="vr_therapy_id" value="{{ $vr_therapy_id }}"> --}}

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
             label="Start Date & Time"
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
            label="Client"
            name="client_id[]"
            multiple="multiple"
            multiple="multiple"
            id="client_id"
         >
         @foreach ($clients as $index => $client)
         <option class="text-dark" value="{{ $index }}">{{ $client['name'] }}</option>
         @endforeach
     
         </x-dashboard.widgets.form.select>

         <input type="hidden" value={{ $user->id }} name='provider_id' id = 'provider_id'>
        
     </x-dashboard.widgets.modal>

     <x-dashboard.widgets.modal
     title="Edit ToDo Listing"
     :url="route('provider.editTodoListingGroup')"
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
         label="Client"
         name="client_id[]"
         multiple="multiple"
         multiple="multiple"
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
            const populateFields = (that,groups,clients) => {
                // console.log(groups);
                const handleMultiSelect = (id, clients, groups) => {
                    const select = document.getElementById(id);
                    const options = select.options;
                  
                    options.forEach(ele=>{
                        console.log('gogo')
                        ele.selected = false;
                    })

                    groups.forEach(group => {
                        if(group.to_do_list_id === that.id){
                            options.forEach(option=>{
                                if(option.value == group.client_id){
                                    option.selected = true;
                                }
                            })      
                        }
                    });
                    
                            
}


                
                // console.log(document.getElementById('editListingClientSelectField').options)
                handleMultiSelect('editListingClientSelectField', clients,groups );
                $('#editListingNameInputField').val(that.title)
                $('#editListingDescriptionsTextareaField').val(that.description)
                $('#editListingStartDateInputField').val(that.start)
                $('#editListingDurationInputField').val(that.duration)
                $('#select2-editListingDurationUnitSelectField').val(that.unit);
                
                
                $('#editListingIdInputField').val(that.id)
                $('#list_id').val(that.id)

                
                
                
            }

        </script>
    </x-slot>
</x-dashboard>
