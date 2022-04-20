@component("mail::message")

# Welcome!! {{ $name }}

@component('mail::button', ['url' => 'https://laravel.com'])
Button Text
@endcomponent

@component('mail::panel')
This is mail panel
@endcomponent

## Table Component:

@component('mail::table')
Mail Table
@endcomponent

@component('mail::subcopy')
This is subcopy component
@endcomponent

Thanks, <br>
{{ config('app.name') }}

@endcomponent

