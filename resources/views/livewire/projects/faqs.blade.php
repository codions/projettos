@section('title', $project->title)@show
@section('image', $project->getOgImage($project->description, 'FAQs - Project'))@show
@section('description', $project->description)@show

@php $faqs = $this->getFaqs() @endphp

@if($faqs->count())
    <div class="space-y-2">
        <div class="max-w-full mx-auto">
            <div class="flex-1 min-w-0">
                <h2 class="text-lg tracking-tight font-bold">{{ trans('projects.faqs') }}</h2>
                <p class="text-gray-500 text-sm">{{ trans('projects.faqs-description') }}</p>
            </div>
        </div>

        <div class="grid 2xl:grid-cols-2 xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-5">
            @foreach($faqs as $faq)
                <x-faq :faq="$faq"/>
            @endforeach
        </div>

        @if($this->showPagination())
            <div class="mt-6">
                <x-tables::pagination
                    :paginator="$faqs"
                    :records-per-page-select-options="[16, 32, 48, 64]"
                />
            </div>
        @endif
    </div>
@else
    <div class="w-full">
        <div class="flex flex-col items-center justify-center max-w-md p-6 mx-auto space-y-6 text-center border rounded-2xl dark:border-gray-700">
            <div
                class="flex items-center justify-center w-16 h-16 text-brand-500 bg-white rounded-full shadow">
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M5.75 12.8665L8.33995 16.4138C9.15171 17.5256 10.8179 17.504 11.6006 16.3715L18.25 6.75"/>
                </svg>
            </div>

            <header class="max-w-sm space-y-1">
                <h2 class="text-xl font-semibold tracking-tight">{{ trans('general.all-caught-up-title') }}</h2>

                <p class="font-medium text-gray-500">
                    {{ trans('projects.no-faqs-created') }}
                </p>
            </header>
        </div>
    </div>
@endif

