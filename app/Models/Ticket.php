<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\Support\MediaStream;

class Ticket extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    const READ = 'read';

    const UNREAD = 'unread';

    const REPLIED = 'replied';

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
        'sent_by',
        'name',
        'email',
        'subject',
        'message',
        'status',
        'is_spam',
    ];

    protected $casts = [
        'is_spam' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

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

    /**
     * Get the user's name.
     */
    public function name(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return $this->user->name ?? $attributes['name'];
            },
        );
    }

    /**
     * Get the user's email.
     */
    public function email(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return $this->user->email ?? $attributes['email'];
            },
        );
    }

    /**
     * Get the user's profile picture.
     */
    public function profilePicture(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->user->profile_picture ?? '/images/users/avatar.png';
            },
        );
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
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
}
