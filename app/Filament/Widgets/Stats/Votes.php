<?php

namespace App\Filament\Widgets\Stats;

use App\Models\Vote;

class Votes extends BaseStat
{
    protected $model = Vote::class;

    public static function make()
    {
        $card = new self;
        $card->labelPlural = __('New Votes');

        return $card->getCard();
    }
}
