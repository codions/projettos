@section('title', 'Page not found')

<x-app-layout>
    <div class="flex flex-col items-center">
        <h1 class="font-bold text-blue-600 text-6xl">{{ __('404') }}</h1>

        <h6 class="mb-2 text-2xl font-bold text-center text-gray-800 md:text-3xl">
            {{ __('Oops! Page not found') }}
        </h6>

        <p class="mb-8 text-center text-gray-500 md:text-lg">
            {{ __('We\'re unable to find this page.') }}
        </p>
    </div>
</x-app-layout>
