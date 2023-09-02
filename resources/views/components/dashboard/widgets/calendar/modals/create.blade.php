@props([
    'title' => 'Add event',
    'url' => null,
])
@php
$faker = \Faker\Factory::create();

$_defaults = [
    'title' => $faker->sentence(),
    'description' => $faker->sentences(rand(3, 8), true),
    'start' => [
        'date' => now()->format('Y-m-d'),
        'time' => now()->format('H:i:s'),
    ],
    'end' => [
        'date' => now()
            ->addMinutes(rand(30, 120))
            ->format('Y-m-d'),
        'time' => now()
            ->addMinutes(rand(30, 120))
            ->format('H:i:s'),
    ],
];
@endphp
@production
    @php
    $_defaults = [
        'title' => '',
        'description' => '',
        'start' => [
            'date' => '',
            'time' => '',
        ],
        'end' => [
            'date' => '',
            'time' => '',
        ],
    ];
    @endphp
@endproduction
<div class="modal fade" id="addEventPopup">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <!-- Modal header (title + close icon) -->
            <div class="modal-header">
                <h5 class="modal-title">{{ CStr::isValidString($title) ? $title : 'Add Event' }}</h5>
                <!-- Close icon -->
                <a href="#" class="close" data-dismiss="modal" aria-label="Close" data-target="#addEventPopup">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <!-- Modal content -->
            <div class="modal-body">
                <form action="{{ $url }}" method="POST" id="addEventForm" class="form-validate is-alter">
                    @csrf
                    <div class="row gx-4 gy-3">
                        <!-- Title -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="event-title">Appointment Title</label>
                                <div class="form-control-wrap">
                                    <input type="text" name="title" class="form-control" id="event-title"
                                        placeholder="Enter a descriptive breif title"
                                        value="{{ $_defaults['title'] }}" required />
                                </div>
                            </div>
                        </div>

                        <!-- Start date and time -->
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Start Date & Time</label>
                                <div class="row gx-2">
                                    <!-- Start date -->
                                    <div class="w-55">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <input type="text" name="start_date" id="event-start-date"
                                                class="form-control date-picker" data-date-format="yyyy-mm-dd"
                                                placeholder="{{ date('Y-m-d') }}"
                                                value={{ $_defaults['start']['date'] }} required />
                                        </div>
                                    </div>

                                    <!-- Start time -->
                                    <div class="w-45">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-clock"></em>
                                            </div>
                                            <input type="text" name="start_time" id="event-start-time"
                                                data-time-format="HH:mm:ss" class="form-control time-picker"
                                                placeholder="{{ date('H:i:s') }}"
                                                value="{{ $_defaults['start']['time'] }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- End date and time -->
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">End Date & Time</label>
                                <div class="row gx-2">
                                    <!-- End date -->
                                    <div class="w-55">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <input type="text" name="end_date" id="event-end-date"
                                                class="form-control date-picker" data-date-format="yyyy-mm-dd"
                                                placeholder="{{ date('Y-m-d') }}"
                                                value={{ $_defaults['end']['date'] }} required />
                                        </div>
                                    </div>

                                    <!-- End time -->
                                    <div class="w-45">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-clock"></em>
                                            </div>
                                            <input type="text" name="end_time" id="event-end-time"
                                                data-time-format="HH:mm:ss" class="form-control time-picker"
                                                placeholder="{{ date('H:i:s') }}"
                                                value="{{ $_defaults['end']['time'] }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="event-description">
                                    Appointment Description
                                </label>
                                <div class="form-control-wrap">
                                    <textarea name="description" class="form-control" id="event-description"
                                        placeholder="Describe the purpose of your appointment in detail">{{ $_defaults['description'] }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Additional fields --}}
                        {{ $slot }}

                        <!-- Action buttons -->
                        <div class="col-12">
                            <ul class="d-flex justify-content-between gx-4 mt-1">
                                <!-- Create button -->
                                <li>
                                    <button id="addEvent" type="submit" class="btn btn-primary">
                                        Add Appointment
                                    </button>
                                </li>
                                <!-- Discard changes button -->
                                <li>
                                    <button id="resetEvent" data-dismiss="modal" class="btn btn-danger btn-dim">
                                        Discard
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
