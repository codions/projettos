<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ColorSettings extends Settings
{
    public string $primary;

    public ?string $favicon;

    public ?string $logo;

    public ?string $fontFamily;

    public static function group(): string
    {
        return 'colors';
    }
}
