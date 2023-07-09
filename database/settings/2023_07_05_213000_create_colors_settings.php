<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateColorsSettings extends SettingsMigration
{
    public function up(): void
    {
        // Colors
        $this->migrator->add('colors.favicon', null);
        $this->migrator->add('colors.fontFamily', 'Nunito');
        $this->migrator->add('colors.logo', null);
        $this->migrator->add('colors.primary', '#2563EB');
    }
}
