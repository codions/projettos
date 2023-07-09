<?php

namespace App\Enums;

enum TicketStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case WAITING_FOR_INFORMATION = 'waiting_for_information';
    case ON_HOLD = 'on_hold';
    case ESCALATED = 'escalated';
    case AWAITING_APPROVAL = 'awaiting_approval';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';
    case CANCELLED = 'cancelled';
    case REOPENED = 'reopened';
}
