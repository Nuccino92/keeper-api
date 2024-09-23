<?php

namespace App\Enums\Event;

enum EventTypeEnum: string
{
    case GAME = 'game';
    case PRACTICE = 'practice';
    case CUSTOM_EVENT = 'custom_event';
}
