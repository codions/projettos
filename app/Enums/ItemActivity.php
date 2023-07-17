<?php

namespace App\Enums;

use App\Models\Item;
use Spatie\Activitylog\Models\Activity;

enum ItemActivity: string
{
    case Created = 'created';
    case LinkedToIssue = 'linked-to-issue';
    case MovedToProject = 'moved-to-project';
    case MovedToBoard = 'moved-to-board';
    case MadePrivate = 'made-private';
    case MadePublic = 'made-public';
    case Pinned = 'pinned';
    case Unpinned = 'unpinned';

    public static function createForItem(Item $item, ItemActivity $itemActivity, array $attributes = []): void
    {
        activity()
            ->performedOn($item)
            ->withProperties(collect(['item-activity' => $itemActivity])->merge(['attributes' => $attributes]))
            ->log($itemActivity->getTranslation($attributes, 'en'));
    }

    public static function getForActivity(Activity $activity): ?self
    {
        $itemActivity = $activity->properties->get('item-activity');

        return self::tryFrom($itemActivity);
    }

    public function getTranslation(array $attributes = [], string $locale = null): string
    {
        return match ($this) {
            self::Created => trans('items.activity.created', [], $locale),
            self::LinkedToIssue => trans('items.activity.linked-to-issue', ['issue_number' => $attributes['issue_number'] ?? ''], $locale),
            self::MovedToProject => trans('items.activity.moved-to-project', ['project' => $attributes['project'] ?? ''], $locale),
            self::MovedToBoard => trans('items.activity.moved-to-board', ['board' => $attributes['board'] ?? ''], $locale),
            self::MadePrivate => trans('items.activity.made-private', [], $locale),
            self::MadePublic => trans('items.activity.made-public', [], $locale),
            self::Pinned => trans('items.activity.pinned', [], $locale),
            self::Unpinned => trans('items.activity.unpinned', [], $locale),
        };
    }
}
