<div class="relative block p-6 border bg-white hover:bg-gray-50 border-gray-200 rounded-xl shadow dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 transform transition-all duration-500">
    <div class="flex flex-row">
        <div class="flex items-center w-full">
            <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
            <div class="dark:text-white">
                <div class="text-lg font-semibold">{{ $faq->question }}</div>
            </div>
        </div>
    </div>
    <div class="my-3">
        <p class="text-gray-500 dark:text-gray-400">
            {!! $faq->answer !!}
        </p>
    </div>
</div>
