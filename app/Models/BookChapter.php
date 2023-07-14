<?php

namespace App\Models;

use App\Traits\HasOgImage;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Spatie\Translatable\HasTranslations;

class BookChapter extends Model
{
    use HasFactory;
    use Sluggable;
    use HasOgImage;
    use Traits\HasUser;
    use HasTranslations;

    public $fillable = [
        'slug',
        'name',
        'description',
        'sort_order',
        'book_id',
        'user_id',
    ];

    public $translatable = ['name', 'description'];

    public function activities(): MorphMany
    {
        return $this->morphMany(ActivitylogServiceProvider::determineActivityModel(), 'subject');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(BookPage::class);
    }
}
