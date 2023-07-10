<?php

namespace App\Models;

use App\Enums\InboxWorkflow;
use App\Settings\GeneralSettings;
use App\Traits\HasOgImage;
use App\Traits\HasUpvote;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Spatie\Tags\HasTags;

class Item extends Model
{
    use HasFactory;
    use Sluggable;
    use HasOgImage;
    use HasUpvote;
    use HasTags;
    use Traits\HasUser;

    public $fillable = [
        'slug',
        'title',
        'content',
        'pinned',
        'private',
        'notify_subscribers',
        'project_id',
        'board_id',
        'user_id',
        'issue_number',
    ];

    protected $casts = [
        'pinned' => 'boolean',
        'private' => 'boolean',
        'notify_subscribers' => 'boolean',
    ];

    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    protected function excerpt(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return Str::limit(strip_tags(str($this->attributes['content'])->markdown()->trim()), 150);
            },
        );
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function subscribedVotes(): MorphMany
    {
        return $this->votes()->where('subscribed', true);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'item_user');
    }

    public function changelogs(): BelongsToMany
    {
        return $this->belongsToMany(Changelog::class);
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(ActivitylogServiceProvider::determineActivityModel(), 'subject');
    }

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
            ->orderBy('order_column');
    }

    public function getCodeAttribute()
    {
        return str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('total_votes', 'desc');
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

    public function scopeForInbox($query)
    {
        return match (app(GeneralSettings::class)->getInboxWorkflow()) {
            InboxWorkflow::WithoutBoardAndProject => $query->whereNull('project_id')->whereNull('board_id'),
            InboxWorkflow::WithoutBoardOrProject => $query->where(fn ($query) => $query->orWhereNull('project_id')->orWhereNull('board_id')),
            InboxWorkflow::WithoutBoard => $query->whereNotNull('project_id')->whereNull('board_id'),
            InboxWorkflow::Disabled => null,
        };
    }

    public function scopeNoChangelogTag($query)
    {
        return $query
            ->whereDoesntHave('tags', function (Builder $query) {
                return $query->where('changelog', '=', true);
            });
    }

    public function isPinned(): bool
    {
        return $this->pinned;
    }

    public function isPrivate(): bool
    {
        return $this->private;
    }
}
