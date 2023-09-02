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
                        <div
                            class="nk-block-head-content align-self-start d-lg-none">
                            <a
                                href="#"
                                class="toggle btn btn-icon btn-trigger mt-n1"
                                data-bs-target="profile-edit"
                            >
                                <em class="icon ni ni-menu-alt-r"></em>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Fields -->
                <div class="nk-block">
                    <div class="nk-data data-list">
                        <div class="data-head">
                            <h6 class="overline-title">Basics</h6>
                        </div>
                        <form
                            action="{{ route('dashboard.profile.update') }}"
                            method="POST"
                            class="mt-4"
                        >
                            @method('PUT')
                            @csrf
                            <div class="row gx-4 gy-3">
                                <!-- Full Name -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            style="font-size: 12px"
                                            for="fullNameInputField"
                                        >
                                            Full Name
                                        </label>
                                        <div class="form-control-wrap">
                                            <input
                                                type="text"
                                                name="name"
                                                class="form-control"
                                                id="fullNameInputField"
                                                value="{{ $user->name }}"
                                                placeholder="Enter your full name"
                                                required
                                            />
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Address -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            style="font-size: 12px"
                                            for="emailInputField"
                                        >

                                        </label>
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-lock-alt"></em>
                                            </div>
                                            <input
                                                type="text"
                                                name="email"
                                                class="form-control"
                                                id="emailInputField"
                                                style="background-color: white;"
                                                value="{{ $user->email }}"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <!-- Phone Number -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            style="font-size: 12px"
                                            for="phoneInputField"
                                        >
                                            Phone Number
                                        </label>
                                        <div class="form-control-wrap">
                                            <input
                                                type="tel"
                                                name="phone"
                                                class="form-control"
                                                id="phoneInputField"
                                                value="{{ $user->phone }}"
                                                placeholder="Enter your phone number"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <!-- Date of Birth -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            style="font-size: 12px"
                                            for="dobInputField"
                                        >
                                            Date of Birth
                                        </label>
                                        <div class="form-control-wrap">
                                            <input
                                                type="date"
                                                name="dob"
                                                class="form-control"
                                                id="dobInputField"
                                                value="{{ $user->dobDate }}"
                                                placeholder="Enter your date of birth"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            style="font-size: 12px"
                                            for="addressInputField"
                                        >
                                            Address
                                        </label>
                                        <div class="form-control-wrap">
                                            <input
                                                type="text"
                                                name="address"
                                                class="form-control"
                                                id="addressInputField"
                                                value="{{ $user->address }}"
                                                placeholder="Enter your address"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            style="font-size: 12px"
                                            for="passwordInputField"
                                        >
                                            Password
                                        </label>
                                        <div class="form-control-wrap">
                                            <input
                                                type="password"
                                                name="password"
                                                class="form-control"
                                                id="passwordInputField"
                                                placeholder="Enter your password"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <!-- Longitude -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            style="font-size: 12px"
                                            for="longitudeInputField"
                                        >
                                            Longitude
                                        </label>
                                        <div class="form-control-wrap">
                                            <input
                                                type="text"
                                                name="longitude"
                                                class="form-control"
                                                id="longitudeInputField"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <!-- Latitude -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            style="font-size: 12px"
                                            for="latitudeInputField"
                                        >
                                            Latitude
                                        </label>
                                        <div class="form-control-wrap">
                                            <input
                                                type="text"
                                                name="latitude"
                                                class="form-control"
                                                id="latitudeInputField"
                                            />
                                        </div>
                                    </div>
                                </div>


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
            <div
                class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg toggle-screen-lg"
                data-content="userAside"
                data-toggle-screen="lg"
                data-toggle-overlay="true"
            >
                <div class="card-inner-group">
                    <div class="card-inner">
                        {{-- Profile overview card (with avatar) --}}
                        <x-dashboard.cards.profile-avatar />
                    </div>
                    <div class="p-0 card-inner">
                        <ul class="link-list-menu">
                            <li>
                                <a href="{{ route('dashboard.profile') }}" class="nk-menu-link">
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
        <script
            async
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKcmmBBBILpqnw_-ydPHUaHehlo0Yz1NM&libraries=places&callback=initialize"
        ></script>

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
        </script>
        <script src="{{ asset('assets/js/profile.js') }}"></script>
    </x-slot>
</x-dashboard>
