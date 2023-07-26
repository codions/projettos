<x-layouts.base>

<div class="bg-white shadow-sm dark:bg-gray-800 dark:border-gray-700">
  <div class="mx-auto py-3 px-2 sm:px-6 md:px-8 max-w-[1500px]">
    <div class="lg:flex lg:items-center lg:justify-between">

        <div class="flex items-center space-x-2">
            <div>
                <x-dynamic-component :component="$project->icon ?? 'heroicon-o-hashtag'"
                    class="w-10 h-10 text-gray-500 dark:text-gray-400"/>
            </div>
            <div class="space-y-1">
                <h2 class="text-lg font-bold text-gray-900 sm:text-xl sm:truncate dark:text-gray-400">
                    <a href="{{ route('projects.home', $project->slug) }}">{{ $project->title }}</a>
                </h2>
                <p class="text-gray-500 dark:text-gray-200 text-sm">{{ str_limit($project->description, 150) }}</p>
            </div>
        </div>


      <div class="mt-5 flex lg:mt-0 lg:ml-4 space-x-2">
        <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
          <svg viewBox="0 0 256 512" class="h-4 mr-2 text-gray-700">
            <path fill="currentColor" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z" class=""></path>
          </svg>
          {{ trans('projects.projects') }}
       </a>

        <button onclick="Livewire.emit('openModal', 'modals.projects.activities', {{ json_encode(['project' => $project->id]) }})" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 448 448" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path d="M234.667 138.667v106.666l91.306 54.187 15.36-25.92-74.666-44.267v-90.666z" fill="#000000" data-original="#000000" class=""></path><path d="M255.893 32C149.76 32 64 117.973 64 224H0l83.093 83.093 1.493 3.093L170.667 224h-64c0-82.453 66.88-149.333 149.333-149.333S405.333 141.547 405.333 224 338.453 373.333 256 373.333c-41.28 0-78.507-16.853-105.493-43.84L120.32 359.68C154.987 394.453 202.88 416 255.893 416 362.027 416 448 330.027 448 224S362.027 32 255.893 32z" fill="#000000" data-original="#000000" class=""></path>
            </svg>
        </button>

        @if(auth()->check() && auth()->user()->hasAdminAccess())
        <span class="relative" x-data="{ open: false }">
          <button type="button" @click="open = true" class="inline-flex items-center px-2 py-2 border border-gray-300 rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50" id="mobile-menu" aria-haspopup="true">
            <svg class="-mr-1 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
            </svg>
          </button>
          <div x-show.transition="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 -mr-1 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-10" aria-labelledby="mobile-menu" role="menu" style="display: none;">
            <a href="/admin/projects/{{ $project->slug }}/edit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">{{ trans('general.edit') }}</a>
          </div>
        </span>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="w-full mx-auto py-5 md:space-x-10 h-full grid grid-cols-6 w-full px-2 sm:px-6 md:px-8 max-w-[1500px]">
   <div class="hidden lg:block">
       <aside class="w-60" aria-label="Sidebar">
           <div class="overflow-y-auto space-y-4">
               <ul class="space-y-2">
                   <li>
                       <a
                           @class([
                                   'flex items-center h-10 px-2 space-x-2 transition rounded-lg ',
                                   'text-white bg-brand-500' => request()->is('projects/*/home'),
                                   'hover:bg-gray-500/5 focus:bg-brand-500/10 focus:text-brand-600 focus:outline-none' => !request()->is('projects/*/home')
                               ])
                           href="{{ route('projects.home', $project->slug) }}">

                           <x-heroicon-o-home class="w-5 h-5 {{ !request()->is('projects/*/home') ? 'text-gray-500' : ''  }}"/>
                           <span class="font-normal">{{ trans('general.home') }}</span>
                       </a>
                   </li>

                   <li>
                       <a
                           @class([
                               'flex items-center h-10 px-2 space-x-2 transition rounded-lg ',
                               'text-white bg-brand-500' => (request()->is('projects/*/boards*') || request()->is('items*')),
                               'hover:bg-gray-500/5 focus:bg-brand-500/10 focus:text-brand-600 focus:outline-none' => (!request()->is('projects/*/boards*') && !request()->is('items*'))
                           ])
                           href="{{ route('projects.boards', $project->slug) }}">

                           <x-heroicon-o-view-boards class="w-5 h-5 {{ (!request()->is('projects/*/boards*') && !request()->is('items*')) ? 'text-gray-500' : ''  }}"/>
                           <span class="font-medium">{{ trans('projects.roadmap') }}</span>
                       </a>
                   </li>

                   <li>
                       <a
                           @class([
                               'flex items-center h-10 px-2 space-x-2 transition rounded-lg ',
                               'text-white bg-brand-500' => request()->is('projects/*/support'),
                               'hover:bg-gray-500/5 focus:bg-brand-500/10 focus:text-brand-600 focus:outline-none' => !request()->is('projects/*/support')
                           ])
                           href="{{ route('projects.support', $project->slug) }}">

                           <x-heroicon-o-support class="w-5 h-5 {{ !request()->is('projects/*/support') ? 'text-gray-500' : ''  }}"/>
                           <span class="font-medium">{{ trans('support.support') }}</span>
                       </a>
                   </li>
                   @if(app(App\Settings\GeneralSettings::class)->enable_changelog)
                   <li>
                       <a
                           @class([
                               'flex items-center h-10 px-2 space-x-2 transition rounded-lg ',
                               'text-white bg-brand-500' => request()->is('projects/*/changelog'),
                               'hover:bg-gray-500/5 focus:bg-brand-500/10 focus:text-brand-600 focus:outline-none' => !request()->is('projects/*/changelog')
                           ])
                           href="{{ route('projects.changelog', $project->slug) }}">

                           <x-heroicon-o-rss class="w-5 h-5 {{ !request()->is('projects/*/changelog') ? 'text-gray-500' : ''  }}"/>
                           <span class="font-medium">{{ trans('projects.changelog.changelog') }}</span>
                       </a>
                   </li>
                   @endif
                   <li>
                       <a
                           @class([
                               'flex items-center h-10 px-2 space-x-2 transition rounded-lg ',
                               'text-white bg-brand-500' => request()->is('projects/*/docs'),
                               'hover:bg-gray-500/5 focus:bg-brand-500/10 focus:text-brand-600 focus:outline-none' => !request()->is('projects/*/docs')
                           ])
                           href="{{ route('projects.docs', $project->slug) }}">

                           <x-heroicon-o-document-text class="w-5 h-5 {{ !request()->is('projects/*/docs') ? 'text-gray-500' : ''  }}"/>
                           <span class="font-medium">{{ trans('projects.docs') }}</span>
                       </a>
                   </li>

                   <li>
                       <a
                           @class([
                               'flex items-center h-10 px-2 space-x-2 transition rounded-lg ',
                               'text-white bg-brand-500' => request()->is('projects/*/faqs'),
                               'hover:bg-gray-500/5 focus:bg-brand-500/10 focus:text-brand-600 focus:outline-none' => !request()->is('projects/*/faqs')
                           ])
                           href="{{ route('projects.faqs', $project->slug) }}">

                           <x-heroicon-o-question-mark-circle class="w-5 h-5 {{ !request()->is('projects/*/faqs') ? 'text-gray-500' : ''  }}"/>
                           <span class="font-medium">{{ trans('projects.faqs') }}</span>
                       </a>
                   </li>
               </ul>
           </div>
       </aside>
   </div>

    <main class="flex-1 h-full col-span-6 lg:col-span-5 lg:border-l lg:pl-5 dark:border-gray-700">
        {{ $slot }}
    </main>
</div>

</x-layouts.base>
