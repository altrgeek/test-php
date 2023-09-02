@component('mail::message')

# Appointment has been updated!

Updated by: **{{ $updater->name }}**

Title: **{{ $appointment->title }}**

Starts At: **{{ $appointment->start }}**

@endcomponent
