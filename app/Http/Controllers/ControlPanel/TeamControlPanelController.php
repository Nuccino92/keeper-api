<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\Api\HttpResponseCodes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class TeamControlPanelController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            [
                'message' => "Teams retrieved successfully"
            ],
            HttpResponseCodes::HttpOK->value
        );
    }


    public function findTeam(): JsonResponse
    {
        return response()->json(
            [
                'message' => "Teams retrieved successfully"
            ],
            HttpResponseCodes::HttpOK->value
        );
    }

    public function updateTeam(): JsonResponse
    {
        return response()->json(
            [
                'message' => "Team updated successfully"
            ],
            HttpResponseCodes::HttpOK->value
        );
    }

    public function deleteTeam(): JsonResponse
    {
        return response()->json(
            [
                'message' => "Teams retrieved successfully"
            ],
            HttpResponseCodes::HttpOK->value
        );
    }

    public function findTeamsForManagement(): JsonResponse
    {
        // if team is not inside the active season we can set can_remove to true automatically to save on perf
        //Cache::remember
        // Cache::forget("league_{$leagueId}_teams_with_properties");
        return response()->json(
            [
                'message' => "Teams retrieved successfully"
            ],
            HttpResponseCodes::HttpOK->value
        );
    }

    public function addTeamToSeason(Request $request)
    {
        // Add team to season logic

        // Invalidate cache
        $leagueId = $request->league_id;
        Cache::forget("league_{$leagueId}_teams_with_properties");
    }

    public function removeTeamFromSeason(Request $request)
    {
        // Remove team from season logic

        // Invalidate cache
        $leagueId = $request->league_id;
        Cache::forget("league_{$leagueId}_teams_with_properties");
    }
}
