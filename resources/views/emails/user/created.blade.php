@component('mail::message')
# Welcome to {{ config('app.name') }}

A new account with **{{ strtolower($role) }}** rights was created against your email address.


Created by **{{ $creator->name }}** <<a href="mailto:{{ $creator->email }}">{{ $creator->email }}</a>>


## Account Details

Name: **{{ $created->name }}**

Email: **{{ $created->email }}**

Password: **{{ $password }}**

@if ($segment)
Segment: **{{ $segment }}**
@endif

@component('mail::button', ['url' => route('login')])
    Login
@endcomponent

@endcomponent
