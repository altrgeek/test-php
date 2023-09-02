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
                    <label class="form-label">Select Client</label>
                    <div class="form-control-wrap">
                        <select
                            name="client_id"
                            id="event-theme"
                            class="select-calendar-theme form-control"
                            data-search="on"
                        >
                            @foreach ($clients as $client)
                                <option value="{{ $client->client_id }}">
                                    {{ $client->name }}
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
            route="provider.dashboard.appointments.client.show"
        />
    </x-slot>
</x-dashboard>
