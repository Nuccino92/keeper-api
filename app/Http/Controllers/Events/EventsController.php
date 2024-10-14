<?php

namespace App\Http\Controllers\Events;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Enums\Api\HttpResponseCodes;
use App\Enums\Event\EventTypeEnum;
use App\Enums\Event\EventRecurrenceEnum;
use App\Http\Controllers\Controller;
use App\Models\League;

use Illuminate\Support\Facades\Log;

class EventsController extends Controller
{
    public function index(Request $request, League $league): JsonResponse
    {



        // We assume active season

        //TODO: listen for specific date 2024-09-22
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
         */

        /**
         *@rules
         *
         * 
         * Step 1: Define Date Ranges
         *
         * Step 2: Fetch Non-recurring Events
         *
         * Step 3: Handle Recurring Events 
         *
         * Step 4: Calculate Recurrence Dates
         *
         * Step 5: Combine Results
         * Check example at bottom of file
         */



        $startDate = $request->query('start');  // Retrieve the date from query parameters
        $endDate = $request->query('end');

        // Default to 1 month before today's date if startDate is not provided
        if (!$startDate) {
            $startDate = now()->subMonth()->format('Y-m-d');
        }

        // Default to 1 month after today's date if endDate is not provided
        if (!$endDate) {
            $endDate = now()->addMonth()->format('Y-m-d');
        }




        // Log::info('Variable value:', ['startDate' => $startDate, 'endDate' => $endDate]);

        $events = [
            [
                'id' => 1,
                'event_type' => EventTypeEnum::GAME,
                'title' => 'Game: Raptors vs Celtics',
                'start' => '2024-10-14 09:30:00+00',
                'end' => '2024-10-14 10:00:00+00',
                'location' => '1187 Roselawn Ave.',
                'description' => '',
                'notes' => '',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 1,
                        'name' => 'Toronto Raptors',
                    ],
                    [
                        'id' => 141,
                        'name' => 'Boston Celtics',
                    ],
                ],
                'recurrence_type' => EventRecurrenceEnum::NONE,
                'recurrence_interval' => 1,
                'recurrence_end' => null
            ],
            [
                'id' => 2,
                'event_type' => EventTypeEnum::GAME,
                'title' => 'Game: Celtics vs Raptors',
                'start' => '2024-10-15 11:30:00+00',
                'end' => '2024-10-15 13:30:00+00',
                'location' => '99 Jiminey Cricket dr.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'notes' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti.',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 141,
                        'name' => 'Boston Celtics',
                    ],
                    [
                        'id' => 1,
                        'name' => 'Toronto Raptors',
                    ],
                ],
                'recurrence_type' => EventRecurrenceEnum::WEEKLY,
                'recurrence_interval' => 1,
                'recurrence_end' => '2025-10-08 11:30:00+00'
            ],
            [
                'id' => 3,
                'event_type' => EventTypeEnum::PRACTICE,
                'title' => 'Practice',
                'start' => '2024-10-16 17:30:00+00',
                'end' => '2024-10-16 22:30:00+00',
                'location' => '',
                'description' => '',
                'notes' => '',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 1,
                        'name' => 'Toronto Raptors',
                    ],
                ],
                'recurrence_type' => EventRecurrenceEnum::DAILY,
                'recurrence_interval' => 2,
                'recurrence_end' => '2025-09-11 11:30:00+00'
            ],
            [
                'id' => 4,
                'event_type' => EventTypeEnum::PRACTICE,
                'title' => 'Practice',
                'start' => '2024-10-18 14:30:00+00',
                'end' => '2024-10-18 18:30:00+00',
                'location' => '104 Westway cres.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'notes' => '',
                'created_by' => 1,
                'teams' => [
                    [
                        'id' => 1,
                        'name' => 'Toronto Raptors',
                    ],
                ],
                'recurrence_type' => EventRecurrenceEnum::NONE,
                'recurrence_interval' => 1,
                'recurrence_end' => null
            ],
            [
                'id' => 5,
                'event_type' => EventTypeEnum::CUSTOM_EVENT,
                'title' => 'This is a tea party for the boys',
                'start' => '2024-10-20 06:30:00+00',
                'end' => '2024-10-20 11:30:00+00',
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
                'recurrence_type' => EventRecurrenceEnum::MONTHLY,
                'recurrence_interval' => 1,
                'recurrence_end' => '2025-10-08 11:30:00+00'
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

        /**
         * TODO!!! WHEN ADDING EVENTS WITH RECURRENCE && TYPE IS GAME, MUST ADD MULTIPLE GAMES
         */

        try {
            return response()->json(['message' => 'Event successfully added'], HttpResponseCodes::HttpOK->value);
        } catch (Exception $e) {
            return response()->json(['error' => $e], HttpResponseCodes::HttpInternalServerError->value);
        }
    }

    public function update(): JsonResponse
    {

        //TODO: validate if its a game & the role is league admin or above

        /**
         * TODO!!! WHEN UPDATING EVENTS WITH RECURRENCE && TYPE IS GAME, MUST UPDATE MULTIPLE GAMES
         * ALSO, IF ANY OF THESE GAMES ARE ALREADY PLAYED, WE WILL FAIL THE UPDATE
         */



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

        /**
         * TODO!!! WHEN DELETING EVENTS WITH RECURRENCE && TYPE IS GAME, MUST DELETE MULTIPLE GAMES
         */

        usleep(400000);

        try {
            return response()->json(['message' => 'Event successfully deleted'], HttpResponseCodes::HttpOK->value);
        } catch (Exception $e) {
            return response()->json(['error' => $e], HttpResponseCodes::HttpInternalServerError->value);
        }
    }
}


/*

// Input
$givenDate = Carbon::parse('2024-09-22');

// Date range (month + 1 week before and after)
$startOfMonth = $givenDate->copy()->startOfMonth()->subWeek();
$endOfMonth = $givenDate->copy()->endOfMonth()->addWeek();

// Non-recurring events
$events = Event::where('recurrence_type', EventRecurrenceEnum::NONE)
    ->whereBetween('start', [$startOfMonth, $endOfMonth])
    ->get();

// Recurring events
$recurringEvents = Event::where('recurrence_type', '!=', EventRecurrenceEnum::NONE)
    ->where(function ($query) use ($startOfMonth, $endOfMonth) {
        $query->whereBetween('start', [$startOfMonth, $endOfMonth])
              ->orWhere('recurrence_end', '>=', $startOfMonth);
    })
    ->get();

// Process recurrence events
foreach ($recurringEvents as $event) {
    $eventStart = Carbon::parse($event->start);
    $eventEnd = $event->recurrence_end ? Carbon::parse($event->recurrence_end) : $endOfMonth;

    $interval = $event->recurrence_interval;

    switch ($event->recurrence_type) {
        case EventRecurrenceEnum::DAILY:
            $occurrences = collect();
            for ($date = $eventStart->copy(); $date->lessThanOrEqualTo($eventEnd); $date->addDays($interval)) {
                if ($date->between($startOfMonth, $endOfMonth)) {
                    $occurrences->push($date->toDateTimeString());
                }
            }
            break;

        case EventRecurrenceEnum::WEEKLY:
            $occurrences = collect();
            for ($date = $eventStart->copy(); $date->lessThanOrEqualTo($eventEnd); $date->addWeeks($interval)) {
                if ($date->between($startOfMonth, $endOfMonth)) {
                    $occurrences->push($date->toDateTimeString());
                }
            }
            break;

        case EventRecurrenceEnum::MONTHLY:
            $occurrences = collect();
            for ($date = $eventStart->copy(); $date->lessThanOrEqualTo($eventEnd); $date->addMonths($interval)) {
                if ($date->between($startOfMonth, $endOfMonth)) {
                    $occurrences->push($date->toDateTimeString());
                }
            }
            break;
    }

    if ($occurrences->isNotEmpty()) {
        $event->occurrences = $occurrences;
    }
}

// Combine regular and recurring events
$allEvents = $events->concat($recurringEvents);

// Return the result
return response()->json($allEvents);

*/