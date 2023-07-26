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

class DocVersion extends Model
{
    use HasFactory;
    use HasTranslations;
    use Traits\HasOgImage;
    use Traits\Sluggable;
    use \Spatie\Sluggable\HasSlug;
    use Traits\HasUser;
    use Traits\CanBeHandled;
    use Traits\LoadTranslation;

    public $fillable = [
        'slug',
        'title',
        'description',
        'visibility',
        'project_id',
        'doc_id',
        'user_id',
    ];

    public $translatable = ['title', 'description'];

    public function activities(): MorphMany
    {
        return $this->morphMany(ActivitylogServiceProvider::determineActivityModel(), 'subject');
    }

    public function doc(): BelongsTo
    {
        return $this->belongsTo(Doc::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(DocPage::class, 'version_id');
    }

    public function duplicateWithPages(Doc $doc = null, ?string $suffix = ' (copy)')
    {
        $duplicateVersion = $this->replicate();

        if (is_string($suffix)) {
            $duplicateVersion->title = $this->title . $suffix;
        }

        if ($doc instanceof Doc) {
            $duplicateVersion->doc_id = $doc->id;
        }

        $duplicateVersion->slug = $this->generateUniqueSlug($this->slug);
        $duplicateVersion->save();

        if ($this->pages->isNotEmpty()) {
            $this->pages()->root()->each(function (DocPage $page) use ($duplicateVersion) {
                $page->duplicateWithSubpages($duplicateVersion, null, null);
            });
        }

        return $duplicateVersion;
    }

    public function editUrl(): Attribute
    {
        return Attribute::make(fn () => route('docs.builder', [
            'docSlug' => $this->doc->slug,
            'versionId' => $this->id,
        ]));
    }
}
