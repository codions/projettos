<?php

namespace App\Models\Traits;

use Spatie\Sluggable\SlugOptions;

trait Sluggable
{
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom($this->getSlugFromFieldName())
            ->saveSlugsTo($this->getSlugFieldName());
    }

    private function getSlugFromFieldName()
    {
        return $this->slugFromFieldName ?? 'title';
    }

    private function getSlugFieldName()
    {
        return $this->slugFieldName ?? 'slug';
    }
}
