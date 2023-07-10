<?php

namespace App\Models;

use App\Traits\HasOgImage;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\Support\MediaStream;

class Project extends Model implements HasMedia
{
    use HasFactory;
    use Sluggable;
    use HasOgImage;
    use Traits\HasUser;
    use InteractsWithMedia;

    public $fillable = [
        'title',
        'slug',
        'group',
        'icon',
        'url',
        'description',
        'repo',
        'pinned',
        'private',
        'sort_order',
    ];

    protected $casts = [
        'pinned' => 'boolean',
        'private' => 'boolean',
    ];

    public function activities(): MorphMany
    {
        return $this->morphMany(ActivitylogServiceProvider::determineActivityModel(), 'subject');
    }

    public function lastUpdatedBy()
    {
        $activity = $this->activities()->latest()->first();

        return $activity->causer;
    }

    public function boards()
    {
        return $this->hasMany(Board::class)->orderBy('sort_order');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_member')->using(ProjectMember::class);
    }

    public function items()
    {
        return $this->hasManyThrough(Item::class, Board::class);
    }

    public function scopeVisibleForCurrentUser($query)
    {
        if (auth()->user()?->hasAdminAccess()) {
            return $query;
        }

        if (auth()->check()) {
            return $query
                ->whereHas('members', fn (Builder $query) => $query->where('user_id', auth()->id()))
                ->orWhere('private', false);
        }

        return $query->where('private', false);
    }

    public function getAttachments()
    {
        return $this->getMedia('project_attachments');
    }

    public function downloadAttachments()
    {
        // Let's get some media.
        $downloads = $this->getAttachments();

        // Download the files associated with the media in a streamed way.
        // No prob if your files are very large.
        return MediaStream::create('attachments.zip')->addMedia($downloads);
    }
}
