<x-dashboard>
    <div class="card">
        <div class="card-aside-wrap">
            <div class="card-inner card-inner-lg">
                <!-- Content header -->
                <div class="nk-block-head nk-block-head-lg">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h4 class="nk-block-title">Personal Information</h4>
                            <div class="nk-block-des">
                                <p>
                                    Basic info, like your name and address, that you use on Cogni™ Platform.
                                </p>
                            </div>
                        </div>
                        <div class="nk-block-head-content align-self-start d-lg-none">
                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                data-bs-target="profile-edit">
                                <em class="icon ni ni-menu-alt-r"></em>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Fields -->
                <div class="nk-block">
                    <div class="nk-data data-list">
                        {{-- <div class="data-head">
                            <h6 class="overline-title">Basics</h6>
                        </div> --}}
                        <form action="{{ route('admin.profile.update') }}" method="POST" class="mt-4">
                            @method('PUT')
                            @csrf
                            <div class="row gx-4 gy-3">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" for="client_name">Business Website Link</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="business_website" value="{{ $admin->website }}"
                                                id="name" placeholder="Enter business website link" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Full Name -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 12px" for="fullNameInputField">
                                            Full Name
                                        </label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="name" class="form-control"
                                                id="fullNameInputField" value="{{ $user->name }}"
                                                placeholder="Enter your full name" required />
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Address -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 12px" for="emailInputField">
                                            Business Email
                                        </label>
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-lock-alt"></em>
                                            </div>
                                            <input type="text" name="email" class="form-control"
                                                id="emailInputField" style="background-color: white;"
                                                value="{{ $user->email }}" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Address -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 12px" for="Pricing">
                                            Pricing Range
                                        </label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="pricing_range" class="form-control" id="Pricing"
                                                style="background-color: white;"
                                                placeholder="Enter your Pricing Range"  value="{{ $admin->pricing_range }}"/>
                                        </div>
                                    </div>
                                </div>
                                <!-- Phone Number -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 12px" for="phoneInputField">
                                            Phone Number
                                        </label>
                                        <div class="form-control-wrap">
                                            <input type="tel" name="phone" class="form-control"
                                                id="phoneInputField" value="{{ $user->phone }}"
                                                placeholder="Enter your phone number" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Accept New clients -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 12px" for="dobInputField">
                                            Accept New clients
                                        </label>
                                        <div class="form-control-wrap">
                                            <select class="form-control" id="default-06" name="accept_clients">
                                                <option value="default_option" selected disabled>Select Option</option>
                                                <option value="Yes">Yes </option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Accept New clients -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 12px" for="dobInputField">
                                            Practice Community  & Tool sharing program 
                                        </label>
                                        <div class="form-control-wrap">
                                            <select class="form-control" id="default-06" name="tool_sharing">
                                                <option value="default_option" selected disabled>Select Option</option>
                                                <option value="Yes">Yes </option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Date of Birth -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 12px" for="dobInputField">
                                            Date of Birth
                                        </label>
                                        <div class="form-control-wrap">
                                            <input type="date" name="dob" class="form-control" id="dobInputField"
                                                value="{{ $user->dobDate }}" placeholder="Enter your date of birth" />
                                        </div>
                                    </div>
                                </div>
{{-- Segment --}}
<div class="col-6">
    <div class="form-group">
        <label class="form-label" for="segment">Type of service </label>
        <div class="form-control-wrap">
            <select name="type_of_service" class="select-calendar-theme form-control"
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
<div class="col-6">
    <div class="form-group">
        <label class="form-label" for="segment">Types of clients </label>
        <div class="form-control-wrap">
            <select  class="form-select js-select2 select2-hidden-accessible" multiple=""
            data-placeholder="Select client type" name="type_of_client" data-maximum-selection-length="3" data-select2-id="9" tabindex="-1"
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
                      <div class="col-6">
                        <div class="form-group">
                            <label class="form-label" for="segment">Service provided  </label>
                            <div class="form-control-wrap">
                                <select  class="form-select js-select2 select2-hidden-accessible" multiple=""
                                data-placeholder="Select Service provided" name="service_provided" data-maximum-selection-length="3" data-select2-id="10" tabindex="-1"
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
                                <!-- Address -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 12px" for="addressInputField">
                                            Address
                                        </label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="address" class="form-control"
                                                id="addressInputField" value="{{ $user->address }}"
                                                placeholder="Enter your address" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 12px" for="passwordInputField">
                                            Password
                                        </label>
                                        <div class="form-control-wrap">
                                            <input type="password" name="password" class="form-control"
                                                id="passwordInputField" placeholder="Enter your password" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Longitude -->
                                {{-- <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 12px" for="longitudeInputField">
                                            Longitude
                                        </label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="longitude" class="form-control"
                                                id="longitudeInputField" />
                                        </div>
                                    </div>
                                </div> --}}

                                <!-- Latitude -->
                                {{-- <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 12px" for="latitudeInputField">
                                            Latitude
                                        </label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="latitude" class="form-control"
                                                id="latitudeInputField" />
                                        </div>
                                    </div>
                                </div> --}}


                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg toggle-screen-lg"
                data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                <div class="card-inner-group">
                    <div class="card-inner">
                        {{-- Profile overview card (with avatar) --}}
                        <x-dashboard.cards.profile-avatar />
                    </div>
                    <div class="p-0 card-inner">
                        <ul class="link-list-menu">
                            <li>
                                <a href="{{ route('admin.profile') }}" class="nk-menu-link">
                                    <em class="icon ni ni-user-fill-c"></em>
                                    <span>Personal Infomation</span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- .card-inner -->
                </div><!-- .card-inner-group -->
            </div><!-- .card-aside -->
        </div><!-- .card-aside-wrap -->
    </div>

    <x-slot name="scripts">
        {{-- <script async
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKcmmBBBILpqnw_-ydPHUaHehlo0Yz1NM&libraries=places&callback=initialize">
        </script>

        <script>
            function initialize() {
                var input = document.getElementById('addressInputField');
                var autocomplete = new google.maps.places.Autocomplete(input);
                google.maps.event.addListener(autocomplete, 'place_changed', function() {
                    var place = autocomplete.getPlace();
                    document.getElementById('latitudeInputField').value = place.geometry.location.lat();
                    document.getElementById('longitudeInputField').value = place.geometry.location.lng();

                });
            }
        </script> --}}
        <script src="{{ asset('assets/js/profile.js') }}"></script>
    </x-slot>
</x-dashboard>
