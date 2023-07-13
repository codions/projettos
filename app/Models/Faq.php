<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Faq extends Model
{
    use HasFactory;
    use Traits\HasUser;

    public $fillable = [
        'question',
        'answer',
        'sort_order',
        'project_id',
        'user_id',
    ];

    protected function excerpt(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return Str::limit(strip_tags(str($this->attributes['answer'])->markdown()->trim()), 150);
            },
        );
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
