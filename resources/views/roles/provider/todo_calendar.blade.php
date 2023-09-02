<x-dashboard title="Task Assigned By Admin">
    <x-slot name="addBtn">
    </x-slot>

    <x-dashboard.widgets.calendar />

    <x-slot name="modals">
        <x-dashboard.widgets.calendar.modals.create />
    </x-slot>

    <x-slot name="scripts">
        <x-dashboard.widgets.calendar.script
            :appointments="$appointments"
            route="provider.showTask"
        />
    </x-slot>
</x-dashboard>
