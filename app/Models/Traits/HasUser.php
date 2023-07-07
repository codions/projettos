<?php

namespace App\Models\Traits;

use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUser
{
    protected static function bootHasUser()
    {
        static::creating(function ($model) {
            $propertyName = $model->getUserPropertyName();

            if (Auth::check() && empty($model->{$propertyName})) {
                $model->{$propertyName} = Auth::user()->id;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->getUserPropertyName());
    }

    public function isOwner($userId = null): bool
    {
        $userId = $userId ?: Auth::user()->id;

        return $userId === $this->{$this->getUserPropertyName()};
    }

    public function scopeOwner($query, $userId = null)
    {
        $userId = $userId ?: Auth::user()->id;

        return $query->where($this->getUserPropertyName(), $userId);
    }

    private function getUserPropertyName()
    {
        return $this->userPropertyName ?? 'user_id';
    }
}
