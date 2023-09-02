<x-dashboard title="Self Guided Therapy To List">
    <x-slot name="addBtn">
    </x-slot>

    <x-dashboard.widgets.calendar />

    <x-slot name="modals">
        <x-dashboard.widgets.calendar.modals.create />
    </x-slot>

    <x-slot name="scripts">
        <x-dashboard.widgets.calendar.script
            :appointments="$appointments"
            route="client.dashboard.client_to_do_preview"
        />
    </x-slot>
</x-dashboard>
