<x-dashboard title="Appointments">
    <x-slot name="addBtn">
        <x-dashboard.widgets.calendar.buttons.add label="Add Appointment" />
    </x-slot>

    <x-dashboard.widgets.calendar />

    <x-slot name="modals">
        <x-dashboard.widgets.calendar.modals.create />
    </x-slot>

    <x-slot name="scripts">
        <x-dashboard.widgets.calendar.script
            :appointments="$appointments"
            route="client.dashboard.appointments.show"
        />
    </x-slot>
</x-dashboard>
