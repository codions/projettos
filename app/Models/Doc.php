<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Spatie\Translatable\HasTranslations;

class Doc extends Model
{
    use HasFactory;
    use HasTranslations;
    use Traits\Sluggable;
    use \Spatie\Sluggable\HasSlug;
    use Traits\HasOgImage;
    use Traits\HasUser;
    use Traits\CanBeHandled;
    use Traits\LoadTranslation;

    public $fillable = [
        'slug',
        'title',
        'description',
        'visibility',
        'order',
        'project_id',
        'user_id',
    ];

    public $translatable = ['title', 'description'];

    public function activities(): MorphMany
    {
        return $this->morphMany(ActivitylogServiceProvider::determineActivityModel(), 'subject');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function versions(): HasMany
    {
        return $this->hasMany(DocVersion::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(DocPage::class);
    }

    public function publicUrl(): Attribute
    {
        return Attribute::make(fn () => route('docs.show', ['docSlug' => $this->slug]));
    }

    public function editUrl(): Attribute
    {
        return Attribute::make(fn () => route('docs.builder', ['docSlug' => $this->slug]));
    }

    public function scopeVisibleForCurrentUser($query)
    {
        if (auth()->user()?->hasAdminAccess()) {
            return $query;
        }

        return $query->whereNot('visibility', 'private');
    }

    public function duplicateWithVersions(?string $suffix = ' (copy)')
    {
        $duplicateDoc = $this->replicate();

        if (is_string($suffix)) {
            $duplicateDoc->title = $this->title . $suffix;
        }

        $duplicateDoc->slug = $this->generateUniqueSlug($this->slug);
        $duplicateDoc->save();

        $this->versions->each(function (DocVersion $version) use ($duplicateDoc) {
            $version->duplicateWithPages($duplicateDoc, null);
        });

        return $duplicateDoc;
    }
}
