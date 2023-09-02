@component('mail::message')

# Your appointment requested has been accepted!


Appointment ID: **{{ $appointment->uid }}**

Title: **{{ $appointment->title }}**

Start Time: **{{ $appointment->start }}**

@endcomponent
