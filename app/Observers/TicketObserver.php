<?php

namespace App\Observers;

use App\Enums\TicketActivity;
use App\Jobs\SendWebhookForNewTicketJob;
use App\Mail\Admin\TicketHasBeenCreatedEmail;
use App\Models\Project;
use App\Models\Ticket;
use App\Notifications\Ticket\TicketUpdatedNotification;
use App\Settings\GeneralSettings;
use Mail;

class TicketObserver
{
    public function created(Ticket $ticket)
    {
        TicketActivity::createForTicket($ticket, TicketActivity::Created);
        $receivers = app(GeneralSettings::class)->send_notifications_to;

        if ($receivers && $ticket->is_root) {
            foreach ($receivers as $receiver) {
                if (! isset($receiver['type'])) {
                    continue;
                }

                if (
                    isset($receiver['projects']) &&
                    Project::whereIn('id', $receiver['projects'])->count() &&
                    ! in_array($ticket->project_id, $receiver['projects'])
                ) {
                    continue;
                }

                match ($receiver['type']) {
                    'email' => Mail::to($receiver['webhook'])->send(new TicketHasBeenCreatedEmail($receiver, $ticket)),
                    'discord', 'slack' => dispatch(new SendWebhookForNewTicketJob($ticket, $receiver)),
                };
            }
        }
    }

    public function updating(Ticket $ticket)
    {
        $notify = false;

        if ($ticket->isDirty('message') && $ticket->message) {
            TicketActivity::createForTicket($ticket, TicketActivity::ChangedTheMessage, [
                'message' => $ticket->message,
            ]);

            $notify = true;
        }

        if ($ticket->isDirty('subject') && $ticket->subject) {
            TicketActivity::createForTicket($ticket, TicketActivity::ChangedTheSubject, [
                'subject' => $ticket->subject,
            ]);

            $notify = true;
        }

        if ($ticket->isDirty('status') && $ticket->status) {
            TicketActivity::createForTicket($ticket, TicketActivity::ChangedStatus, [
                'status' => $ticket->status,
            ]);

            $notify = true;
        }

        if ($ticket->isDirty('project_id') && $ticket->project) {
            TicketActivity::createForTicket($ticket, TicketActivity::MovedToProject, [
                'project' => $ticket->project->title,
            ]);

            $notify = true;
        }

        if ($notify) {
            $ticket->user->notify(new TicketUpdatedNotification($ticket));
        }
    }

    public function deleting(Ticket $ticket)
    {

    }
}
