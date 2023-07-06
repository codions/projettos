<?php

namespace App\Filament\Widgets\Stats;

use App\Models\Ticket;

class Tickets extends BaseStat
{
    protected $model = Ticket::class;

    public function getQuery()
    {
        return $this->model::root();
    }

    public static function make()
    {
        $card = new self;
        $card->labelPlural = __('New Tickets');

        return $card->getCard();
    }
}
