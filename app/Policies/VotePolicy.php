<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Auth\Access\HandlesAuthorization;

class VotePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole(UserRole::Admin, UserRole::Employee);
    }

    public function view(User $user, Vote $model)
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function create(User $user)
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function update(User $user, Vote $model)
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function delete(User $user, Vote $model)
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function restore(User $user, Vote $model)
    {
        return $user->hasRole(UserRole::Admin);
    }

    public function forceDelete(User $user, Vote $model)
    {
        return $user->hasRole(UserRole::Admin);
    }
}
