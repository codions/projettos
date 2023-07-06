<?php

namespace App\Filament\Widgets\Stats;

use App\Models\User;

class Users extends BaseStat
{
    protected $model = User::class;

    public static function make()
    {
        $card = new self;
        $card->labelPlural = __('New Users');

        return $card->getCard();
    }
}
