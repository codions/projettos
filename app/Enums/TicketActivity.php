<?php

namespace App\Enums;

use App\Models\Ticket;
use Spatie\Activitylog\Models\Activity;

enum TicketActivity: string
{
    case Created = 'created';
    case LinkedToIssue = 'linked-to-issue';
    case MovedToProject = 'moved-to-project';
    case ChangedStatus = 'changed-status';
    case ChangedTheSubject = 'changed-the-subject';
    case ChangedTheMessage = 'changed-the-message';

    public static function createForTicket(Ticket $ticket, TicketActivity $ticketActivity, array $attributes = []): void
    {
        activity()
            ->performedOn($ticket)
            ->withProperties(collect(['ticket-activity' => $ticketActivity])->merge(['attributes' => $attributes]))
            ->log($ticketActivity->getTranslation($attributes, 'en'));
    }

    public static function getForActivity(Activity $activity): ?self
    {
        $ticketActivity = $activity->properties->get('ticket-activity');

        return self::tryFrom($ticketActivity);
    }

    public function getTranslation(array $attributes = [], string $locale = null): string
    {
        return match ($this) {
            self::Created => trans('tickets.activity.created', [], $locale),
            self::LinkedToIssue => trans('tickets.activity.linked-to-issue', ['issue_number' => $attributes['issue_number'] ?? ''], $locale),
            self::MovedToProject => trans('tickets.activity.moved-to-project', ['project' => $attributes['project'] ?? ''], $locale),
            self::ChangedStatus => trans('tickets.activity.changed-status', ['status' => $attributes['status'] ?? ''], $locale),
            self::ChangedTheSubject => trans('tickets.activity.changed-the-subject', [], $locale),
            self::ChangedTheMessage => trans('tickets.activity.changed-the-message', [], $locale),
        };
    }
}
