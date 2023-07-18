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

class DocPage extends Model
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
        'content',
        'content_type',
        'order',
        'visibility',
        'project_id',
        'doc_id',
        'chapter_id',
        'parent_id',
        'version_id',
        'user_id',
        'is_draft',
    ];

    protected $casts = [
        'is_draft' => 'boolean',
    ];

    public $translatable = ['title', 'content'];

    public function activities(): MorphMany
    {
        return $this->morphMany(ActivitylogServiceProvider::determineActivityModel(), 'subject');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function doc(): BelongsTo
    {
        return $this->belongsTo(Doc::class);
    }

    public function version(): BelongsTo
    {
        return $this->belongsTo(DocVersion::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function isRoot(): Attribute
    {
        return Attribute::make(fn () => is_null($this->parent_id));
    }

    public function publicUrl(): Attribute
    {
        if ($this->is_root) {
            return Attribute::make(fn () => route('docs.show', [
                'docSlug' => $this->doc->slug,
                'versionSlug' => $this->version->slug,
                'chapterSlug' => $this->slug,
            ]));
        }

        return Attribute::make(fn () => route('docs.show', [
            'docSlug' => $this->doc->slug,
            'versionSlug' => $this->version->slug,
            'chapterSlug' => $this->parent->slug,
            'pageSlug' => $this->slug,
        ]));
    }

    public function editUrl(): Attribute
    {
        return Attribute::make(fn () => route('docs.builder', [
            'slug' => $this->doc->slug,
            'versionId' => $this->version_id,
            'pageId' => $this->id,
        ]));
    }
}
