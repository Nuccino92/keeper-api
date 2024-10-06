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

        // We assume active season

        //TODO: listen for specific date/date range (1 specific day, 1 specific week 1 specific month):
        //TODO: listen for the teams involved (team slug in url param) & the type of event, could be all teams & only games, could be 1 team and all events.. etc.

        // example start/end - "2024-10-01T02:30:00.000Z"

        /**
         * if (event_type === EventTypeEnum::GAME) {
         *  validate 2 teams 
         *  
         *  if(2 teams) {
         *      first create the game, w/ home/away teams and get the id for the eventable id
         *      create 2 events 1 for each team  using game id as eventable id's
         * 
         *               
         *      
         *   }
         * 
         * }
         * 
         */

        $events = [
            [
                'id' => 1,
                'event_type' => EventTypeEnum::GAME,
                'title' => 'Game: Raptors vs Celtics',
                'start' => '2024-09-30 09:30:00+00',
                'end' => '2024-09-30 10:00:00+00',
                'location' => '1187 Roselawn Ave.',
                'description' => '',
                'notes' => '',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 1,
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
                'start' => '2024-10-01 11:30:00+00',
                'end' => '2024-10-01 13:30:00+00',
                'location' => '99 Jiminey Cricket dr.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'notes' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti.',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 141,
                        'name' => "Boston Celtics"
                    ],
                    [
                        'id' => 1,
                        'name' => "Toronto Raptors"
                    ],
                ]
            ],
            [
                'id' => 3,
                'event_type' => EventTypeEnum::PRACTICE,
                'title' => 'Practice',
                'start' => '2024-10-02 17:30:00+00',
                'end' => '2024-10-02 22:30:00+00',
                'location' => '',
                'description' => '',
                'notes' => '',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 1,
                        'name' => "Toronto Raptors"
                    ]
                ]
            ],
            [
                'id' => 4,
                'event_type' => EventTypeEnum::PRACTICE,
                'title' => 'Practice',
                'start' => '2024-10-04 14:30:00+00',
                'end' => '2024-10-04 18:30:00+00',
                'location' => '104 Westway cres.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'notes' => '',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 1,
                        'name' => 'Toronto Raptors',
                    ],
                ]
            ],
            [
                'id' => 5,
                'event_type' => EventTypeEnum::CUSTOM_EVENT,
                'title' => 'This is a tea party for the boys',
                'start' => '2024-10-06 06:30:00+00',
                'end' => '2024-10-06 11:30:00+00',
                'location' => '',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'notes' => '',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 1,
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

    public function add(): JsonResponse
    {

        // We assume active season

        //TODO: validate if its a game & the role is league admin or above

        try {
            return response()->json(['message' => 'Event successfully added'], HttpResponseCodes::HttpOK->value);
        } catch (Exception $e) {
            return response()->json(['error' => $e], HttpResponseCodes::HttpInternalServerError->value);
        }
    }

    public function update(): JsonResponse
    {

        //TODO: validate if its a game & the role is league admin or above

        try {
            return response()->json(['message' => 'Event successfully updated'], HttpResponseCodes::HttpOK->value);
        } catch (Exception $e) {
            return response()->json(['error' => $e], HttpResponseCodes::HttpInternalServerError->value);
        }
    }

    public function delete(League $league): JsonResponse
    {

        // public function events()
        // {
        //     return $this->hasMany(Event::class, 'eventable_id');
        // }

        // if event type is game run events delete method to delete all the events with matching eventable id

        //  $game->events()->delete();


        //TODO: check if the event type is a gane, if it is a game then check if the game has been played. if the game hasnt been played then deny the delete request

        //TODO: remove this delay when api is ready
        usleep(400000);

        try {
            return response()->json(['message' => 'Event successfully deleted'], HttpResponseCodes::HttpOK->value);
        } catch (Exception $e) {
            return response()->json(['error' => $e], HttpResponseCodes::HttpInternalServerError->value);
        }
    }
}
