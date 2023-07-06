<?php

namespace App\Filament\Widgets\Stats;

use App\Models\Item;

class Items extends BaseStat
{
    protected $model = Item::class;

    public static function make()
    {
        $card = new self;
        $card->labelPlural = __('New Items');

        return $card->getCard();
    }
}
