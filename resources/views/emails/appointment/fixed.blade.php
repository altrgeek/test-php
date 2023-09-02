@component('mail::message')

# A new appointment has been fixed with you

Appointment ID: **{{ $appointment->uid }}**

Title: **{{ $appointment->title }}**

Start Time: **{{ $appointment->start }}**

Fixed By: **{{ $fixer->name }}** <a href="mailto:{{ $fixer->email }}">{{ $fixer->email }}</a>

@endcomponent
