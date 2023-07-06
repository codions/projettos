<?php

namespace Codions\FilamentCustomFields;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentCustomFieldsServiceProvider extends PluginServiceProvider
{
    protected function getResources(): array
    {
        return config('filament-custom-fields.resources', []);
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-custom-fields')
            ->hasConfigFile()
            ->hasMigration('create_custom_fields_tables');
    }
}
