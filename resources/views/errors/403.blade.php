<x-layouts.error>
    <div class="flex flex-col items-center">
        <h1 class="font-bold text-blue-600 text-9xl">{{ __('403') }}</h1>

        <h6 class="mb-2 text-2xl font-bold text-center text-gray-800 md:text-3xl">
            {{ __('Forbidden') }}
        </h6>

        <p class="mb-8 text-center text-gray-500 md:text-lg">
            {{ __('You don\'t have permission to access this resource.') }}
        </p>

        <a href="/" class="outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed rounded gap-x-2 text-base px-4 py-2     ring-primary-500 text-white bg-primary-500 hover:bg-primary-600 hover:ring-primary-600
dark:ring-offset-slate-800 dark:bg-primary-700 dark:ring-primary-700
dark:hover:bg-primary-600 dark:hover:ring-primary-600 mt-3 w-full">{{ __('Go home') }}</a>
    </div>
</x-layouts.error>
