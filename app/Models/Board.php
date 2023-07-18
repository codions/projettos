<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;
    use Traits\Sluggable;
    use \Spatie\Sluggable\HasSlug;
    use Traits\HasOgImage;

    const SORT_ITEMS_BY_POPULAR = 'popular';

    const SORT_ITEMS_BY_LATEST = 'latest';

    public $fillable = [
        'slug',
        'title',
        'visible',
        'order',
        'description',
        'block_votes',
        'sort_items_by',
        'block_comments',
        'can_users_create',
    ];

    public $casts = [
        'visible' => 'boolean',
        'can_users_create' => 'boolean',
        'block_comments' => 'boolean',
        'block_votes' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    public function canUsersCreateItem()
    {
        return $this->can_users_create;
    }
}
