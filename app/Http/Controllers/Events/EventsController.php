<?php

namespace App\Http\Controllers\Events;

use App\Enums\Api\HttpResponseCodes;
use App\Enums\Event\EventTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\League;
use Exception;
use Illuminate\Http\JsonResponse;

class EventsController extends Controller
{
    public function index(League $league): JsonResponse
    {


        //TODO: listen for the teams involved (team slug in url param) & the type of event, could be all teams & only games, could be 1 team and all events.. etc.

        $events = [
            [
                'id' => 1,
                'event_type' => EventTypeEnum::GAME,
                'title' => 'Game: Raptors vs Celtics',
                'start' => '2024-09-22 09:30:00+00',
                'end' => '2024-09-22 11:30:00+00',
                'location' => '',
                'description' => '',
                'notes' => '',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 14,
                        'name' => "Toronto Raptors"
                    ],
                    [
                        'id' => 141,
                        'name' => "Boston Celtics"
                    ]
                ]
            ],
            [
                'id' => 2,
                'event_type' => EventTypeEnum::GAME,
                'title' => 'Game: Celtics vs Raptors',
                'start' => '2024-09-21 11:30:00+00',
                'end' => '2024-09-21 13:30:00+00',
                'location' => '',
                'description' => '',
                'notes' => '',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 141,
                        'name' => "Boston Celtics"
                    ],
                    [
                        'id' => 14,
                        'name' => "Toronto Raptors"
                    ],
                ]
            ],
            [
                'id' => 3,
                'event_type' => EventTypeEnum::PRACTICE,
                'title' => 'Game: Raptors vs Celtics',
                'start' => '2024-09-20 17:30:00+00',
                'end' => '2024-09-20 22:30:00+00',
                'location' => '',
                'description' => '',
                'notes' => '',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 14,
                        'name' => "Toronto Raptors"
                    ]
                ]
            ],
            [
                'id' => 4,
                'event_type' => EventTypeEnum::PRACTICE,
                'title' => 'Game: Raptors vs Celtics',
                'start' => '2024-09-19 14:30:00+00',
                'end' => '2024-09-19 18:30:00+00',
                'location' => '',
                'description' => '',
                'notes' => '',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 14,
                        'name' => 'Toronto Raptors',
                    ],
                ]
            ],
            [
                'id' => 5,
                'event_type' => EventTypeEnum::CUSTOM_EVENT,
                'title' => 'Game: Raptors vs Celtics',
                'start' => '2024-09-18 06:30:00+00',
                'end' => '2024-09-18 11:30:00+00',
                'location' => '',
                'description' => '',
                'notes' => '',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 14,
                        'name' => 'Toronto Raptors',
                    ],
                ],
            ],
        ];

        try {
            return response()->json(['data' => $events, 'message' => 'Successfully retrieved events'], HttpResponseCodes::HttpOK->value);
        } catch (Exception $e) {
            return response()->json(['error' => $e], HttpResponseCodes::HttpInternalServerError->value);
        }
    }
}
