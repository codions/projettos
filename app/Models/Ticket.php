<?php

namespace App\Models;

use App\Settings\GeneralSettings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\Support\MediaStream;

class Ticket extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    use Traits\HasUuid;
    use Traits\HasUser;

    const ACCEPTED_FILE_TYPES = [
        'image/bmp',
        'image/jpeg',
        'image/x-png',
        'image/png',
        'image/gif',
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'video/mp4',
        'video/mpeg',
    ];

    public $fillable = [
        'project_id',
        'parent_id',
        'user_id',
        'subject',
        'message',
        'status',
        'read_at',
    ];

    protected static $recordEvents = ['updated'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(ActivitylogServiceProvider::determineActivityModel(), 'subject');
    }

    public function lastUpdatedBy()
    {
        $activity = $this->activities()->latest()->first();

        return $activity->causer;
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function isRoot(): Attribute
    {
        return Attribute::make(fn () => is_null($this->parent_id));
    }

    public function statusLabel(): Attribute
    {
        $statuses = app(GeneralSettings::class)->ticket_statuses;

        return Attribute::make(fn () => ! is_null($this->status) ? $statuses[$this->status]['label'] : null);
    }

    public function isClosed(): Attribute
    {
        return Attribute::make(fn () => $this->status === 'closed');
    }

    public function code(): Attribute
    {
        return Attribute::make(fn () => str_pad($this->attributes['id'], 6, '0', STR_PAD_LEFT));
    }

    public function getAttachments()
    {
        return $this->getMedia('ticket_attachments');
    }

    public function downloadAttachments()
    {
        // Let's get some media.
        $downloads = $this->getAttachments();

        // Download the files associated with the media in a streamed way.
        // No prob if your files are very large.
        return MediaStream::create('attachments.zip')->addMedia($downloads);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['subject', 'message', 'status', 'read_at'])->logOnlyDirty();
    }

    public function scopeVisibleForCurrentUser(Builder $query)
    {
        if (auth()->user()?->hasAdminAccess()) {
            return $query;
        }

        return $query->where('private', 0)->where(function (Builder $query) {
            return $query->whereRelation('project', 'private', 0)->orWhereNull('items.project_id');
        });
    }

    public function canBeEdited()
    {
        if (auth()->user()?->hasAdminAccess()) {
            return true;
        }

        if ($this->isOwner()) {
            return ! (($this->is_root) ? $this->is_closed : $this->parent->is_closed);
        }

        return false;
    }

    public function canBeDeleted()
    {
        if (auth()->user()?->hasAdminAccess()) {
            return true;
        }

        return $this->isOwner();
    }
}
