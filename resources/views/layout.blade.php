<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Blade Sortable Demo</title>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <livewire:styles/>
</head>
<body>
<div class="mx-auto container py-8 space-y-8">
    @yield('content')
</div>

<livewire:scripts/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.2/alpine-ie11.min.js"></script>

<x-laravel-blade-sortable::scripts/>

<script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>
