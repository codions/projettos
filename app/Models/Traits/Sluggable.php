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

    private function generateUniqueSlug($slug)
    {
        $count = 1;
        $uniqueSlug = $slug;

        while ($this->slugExistsInRelationshipScope($uniqueSlug)) {
            $uniqueSlug = $slug . '-' . $count;
            $count++;
        }

        return $uniqueSlug;
    }

    private function slugExistsInRelationshipScope($slug)
    {
        return self::where('slug', $slug)->exists();
    }
}
