@component('mail::message')

# Got a new appointment request!

Requested by: **{{ $requester->name }}**

Title: **{{ $appointment->title }}**

Starts At: **{{ $appointment->start }}**

@endcomponent
