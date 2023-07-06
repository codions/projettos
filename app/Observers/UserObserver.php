<?php

namespace App\Observers;

use App\Jobs\Items\RecalculateItemsVotes;
use App\Models\User;

class UserObserver
{
    public function deleting(User $user)
    {
        dispatch(new RecalculateItemsVotes($user->items()->pluck('id')));

        $user->mentions()->delete();
        $user->votes()->delete();
        $user->comments()->delete();
        $user->userSocials()->delete();
        $user->items()->update(['user_id' => null]);
    }
}
