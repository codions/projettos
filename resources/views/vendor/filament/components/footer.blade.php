@if (config('filament.layout.footer.should_show_logo'))
    <div class="flex items-center justify-center filament-footer">
        <a
            href="#"
            target="_blank"
            rel="noopener noreferrer"
            class="text-center text-gray-300 hover:text-primary-500 transition"
        >
        <img class="fill-current w-24 my-auto" src="/images/logos/logo-color.png" alt="{{ config('app.name') }}">
        </a>
    </div>
@endif
