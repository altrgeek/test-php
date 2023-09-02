<x-dashboard title="Appointments">
    <x-slot name="addBtn">
        <x-dashboard.widgets.calendar.buttons.add label="Add Appointment" />
    </x-slot>

    <x-dashboard.widgets.calendar />

    <x-slot name="modals">
        <x-dashboard.widgets.calendar.modals.create>
            <!-- Provider selection -->
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Select Provider</label>
                    <div class="form-control-wrap">
                        <select
                            name="provider_id"
                            id="event-theme"
                            class="select-calendar-theme form-control"
                            data-search="on"
                        >
                            @foreach ($providers as $provider)
                                <option value="{{ $provider->provider_id }}">
                                    {{ $provider->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @php
                $platforms = [
                    'Cognimeet',
                    'Zoom Meet',
                    'Google Meet',
                ];
            @endphp
        <!-- Meeting Platform -->
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="event-description">
                    Select Meeting Platform
                </label>
                <select name="meeting_platform" class="select-calendar-theme form-control" id="">
                    @foreach ($platforms as $platform)
                        <option value="{{ $platform }}">
                            {{ $platform }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        </x-dashboard.widgets.calendar.modals.create>
    </x-slot>

    <x-slot name="scripts">
        <x-dashboard.widgets.calendar.script
            :appointments="$appointments"
            route="admin.dashboard.appointments.provider.show"
        />
    </x-slot>
</x-dashboard>
