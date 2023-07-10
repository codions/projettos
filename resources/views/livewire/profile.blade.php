<div class="space-y-6">
    <form class="space-y-4" wire:submit.prevent="submit">
        {{ $this->form }}

        <div class="flex justify-between">
            <div>
                <x-filament::button wire:click="submit">
                    {{ trans('profile.save') }}
                </x-filament::button>

                <x-filament::button type="button" color="secondary" wire:click="logoutConfirm">
                    {{ trans('profile.logout') }}
                </x-filament::button>
            </div>

            <div>
                <x-filament::button type="button" color="danger" wire:click="deleteConfirm">
                    {{ trans('profile.delete-account') }}
                </x-filament::button>
            </div>
        </div>
    </form>

    @if($hasSsoLoginAvailable)
        <div>
            <h2 class="text-lg tracking-tight font-bold">{{ trans('profile.social-login') }}</h2>
            <p class="text-gray-500 dark:text-gray-300 text-sm">{{ trans('profile.social-login-description') }}</p>
        </div>

        {{ $this->table }}
    @endif

    <x-filament::modal id="logoutConfirm" width="md">
        <x-slot name="heading">
            {{ trans('profile.logout-confirmation') }}
        </x-slot>

        <p>{{ trans('profile.logout-warning') }}</p>

        <x-slot name="footer">
            <x-filament::modal.actions full-width>
                <x-filament::button wire:click="closeLogoutConfirm" color="secondary">
                    {{ trans('profile.logout-cancel') }}
                </x-filament::button>

                <x-filament::button wire:click="logout" color="primary">
                    {{ trans('profile.logout') }}
                </x-filament::button>
            </x-filament::modal.actions>
        </x-slot>
    </x-filament::modal>

    <x-filament::modal id="deleteAccount" width="md">
        <x-slot name="heading">
            {{ trans('profile.delete-account-confirmation') }}
        </x-slot>

        <p>{{ trans('profile.delete-account-warning') }}</p>

        <x-slot name="footer">
            <x-filament::modal.actions full-width>
                <x-filament::button wire:click="closeDeleteConfirm" color="secondary">
                    {{ trans('profile.delete-account-cancel') }}
                </x-filament::button>

                <x-filament::button wire:click="delete" color="danger">
                    {{ trans('profile.delete-account') }}
                </x-filament::button>
            </x-filament::modal.actions>
        </x-slot>
    </x-filament::modal>
</div>
