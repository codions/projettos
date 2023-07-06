<?php

namespace App\Jobs\Items;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class RecalculateItemsVotes implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public Collection $itemIds)
    {
    }

    public function handle()
    {
        Item::query()
            ->whereIn('id', $this->itemIds->toArray())
            ->each(function (Item $item) {
                $item->total_votes = $item->votes()->count();
            });
    }
}
