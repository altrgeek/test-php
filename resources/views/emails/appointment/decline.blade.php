@component('mail::message')

# Your appointment request has been declined!

Appointment ID: **{{ $appointment->uid }}**

Title: **{{ $appointment->title }}**

Start Time: **{{ $appointment->start }}**

Declined By: **{{ $decliner->name }}** <a href="mailto:{{ $decliner->email }}">{{ $decliner->email }}</a>

@endcomponent
