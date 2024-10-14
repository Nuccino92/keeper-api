<?php

namespace App\Enums\Event;

enum EventRecurrenceEnum: string
{
    case NONE = 'none';
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
}
