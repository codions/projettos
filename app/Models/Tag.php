<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Tag extends \Spatie\Tags\Tag
{
    public function items()
    {
        return $this->morphedByMany(Item::class, 'taggable');
    }
}
