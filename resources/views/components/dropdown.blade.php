<div {{ $attributes->merge(['class' => 'relative inline-block text-left']) }}
    x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false"
    {{ $attributes->only('wire:key') }}>
    <div class="cursor-pointer focus:outline-none" x-on:click="open = !open">
        @if (isset($trigger))
            {{ $trigger }}
        @else
            <x-dynamic-component
                component="icon-svg"
                class="w-4 h-4 text-secondary-500 hover:text-secondary-700
                     dark:hover:text-secondary-600 transition duration-150 ease-in-out"
                name="dots-vertical"
            />
        @endif
    </div>

    <div x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        {{ $attributes->except('wire:key')->class([
            $getAlign(),
            $width,
            'z-30 absolute mt-2 whitespace-nowrap'
        ]) }}
        style="display: none;"
        @unless($persistent) x-on:click="close" @endunless>
        <div class="relative {{ $height }} soft-scrollbar overflow-auto border border-secondary-200
                    rounded-lg shadow-lg p-1 bg-white dark:bg-secondary-800 dark:border-secondary-600">
            {{ $slot }}
        </div>
    </div>
</div>
