<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Xetaio\Mentions\Models\Mention;
use Xetaio\Mentions\Models\Traits\HasMentionsTrait;

class Comment extends Model
{
    use HasFactory;
    use HasMentionsTrait;
    use LogsActivity;
    use Traits\HasUpvote;
    use Traits\HasUser;

    public $fillable = [
        'content',
        'parent_id',
        'user_id',
        'private',
    ];

    protected $casts = [
        'private' => 'boolean',
    ];

    protected static $recordEvents = ['updated'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function mentions()
    {
        return $this->morphMany(Mention::class, 'model');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['content'])->logOnlyDirty();
    }

    public function scopePublic($query)
    {
        return $query->where('private', false);
    }
}
