<!DOCTYPE html>
<html
    x-cloak
    x-data="{darkMode: localStorage.getItem('dark') === 'true'}"
    x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
    x-bind:class="{'dark': darkMode}"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Welcome') - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family={{ $fontFamily['urlValue'] }}" rel="stylesheet" />

    <style>
        body {
            font-family: '{{ $fontFamily['cssValue'] }}', sans-serif;
        }
    </style>

    {!! $brandColors !!}

    @vite('resources/css/app.css')


    @if(file_exists($favIcon = storage_path('app/public/favicon.png')))
        <link href="{{ asset('storage/favicon.png') }}?v={{ md5_file($favIcon) }}" rel="icon" type="image/x-icon"/>
    @endif

    @livewireStyles

    @include('partials.meta')

    @if($blockRobots)
        <meta name="robots" content="noindex">
    @endif
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900">

@if($userNeedsToVerify)
    <div class="relative bg-brand-600">
        <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
            <div class="pr-16 sm:text-center sm:px-16">
                <p class="font-medium text-white">
                    <span class="md:inline"> You have not verified your email yet, please verify your email.</span>
                    <span class="block sm:ml-2 sm:inline-block">
          <a href="{{ route('verification.notice') }}" class="text-white font-bold underline"> Verify <span
                  aria-hidden="true">&rarr;</span></a>
        </span>
                </p>
            </div>
        </div>
    </div>
@endif

@include('partials.header', ['logo' => $logo])

{{ $slot }}

<x-filament::notification-manager/>

@livewire('livewire-ui-spotlight')
@livewire('livewire-ui-modal')

@livewireScripts
@vite('resources/js/app.js')
@stack('javascript')
@livewire('notifications')
{!! app(\App\Settings\GeneralSettings::class)->custom_scripts !!}
</body>
</html>
