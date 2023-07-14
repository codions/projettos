<?php

namespace App\Models;

use App\Traits\HasOgImage;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Spatie\Translatable\HasTranslations;

class BookPage extends Model
{
    use HasFactory;
    use Sluggable;
    use HasOgImage;
    use Traits\HasUser;
    use HasTranslations;

    public $fillable = [
        'slug',
        'name',
        'content',
        'content_type',
        'sort_order',
        'book_id',
        'chapter_id',
        'user_id',
        'is_draft',
    ];

    protected $casts = [
        'is_draft' => 'boolean',
    ];

    public $translatable = ['name', 'content'];

    public function activities(): MorphMany
    {
        return $this->morphMany(ActivitylogServiceProvider::determineActivityModel(), 'subject');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(BookChapter::class);
    }
}
