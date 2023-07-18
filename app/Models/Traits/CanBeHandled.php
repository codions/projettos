<?php

namespace App\Models\Traits;

trait CanBeHandled
{
    public function canBeEdited()
    {
        if (auth()->user()?->hasAdminAccess()) {
            return true;
        }

        return $this->isOwner();
    }

    public function canBeDeleted()
    {
        if (auth()->user()?->hasAdminAccess()) {
            return true;
        }

        return $this->isOwner();
    }

    public function scopeCanBeHandledForCurrentUser($query)
    {
        if (auth()->user()?->hasAdminAccess()) {
            return $query;
        }

        return $this->owner();
    }
}
