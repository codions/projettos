<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Changelog extends Model
{
    use HasFactory;
    use Traits\Sluggable;
    use \Spatie\Sluggable\HasSlug;
    use Traits\HasOgImage;
    use Traits\HasUser;
    use Traits\AdditionalData;

    public $fillable = [
        'project_id',
        'slug',
        'title',
        'content',
        'published_at',
        'user_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'board_ids',
        'item_ids',
    ];

    public function getBoardIdsAttribute(): array
    {
        return $this->getData('board_ids', []);
    }

    public function getItemIdsAttribute(): array
    {
        return $this->getData('item_ids', []);
    }

    public function getItemsAttribute(): Collection
    {
        return $this->items()->get();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_at', '<=', now())->latest('published_at');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function items(): Builder
    {
        return Item::query()->whereIn('id', $this->item_ids);
    }
}
