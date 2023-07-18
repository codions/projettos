<?php

namespace App\Models\Traits;

trait LoadTranslation
{
    public static function loadTranslation(?string $locale): self
    {
        if (! is_null($locale)) {
            return self::usingLocale($locale);
        }

        return new self();
    }
}
