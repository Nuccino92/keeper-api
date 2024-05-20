<?php

namespace App\Http\Controllers;

use App\Enums\Api\HttpResponseCodes;
use App\Models\League;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Requests\League\LeagueRequest;

class ControlPanelController extends Controller
{
    public function index(League $league): JsonResponse
    {
        try {
            return response()->json(['data' => [
                'league_info' => $league, 'seasons' => [
                    'all_seasons' => [
                        ['id' => '1', 'name' => '2019-2020 Bball season'],
                        ['id' => '2', 'name' => '2020-2021 Bball season'],
                        ['id' => '3', 'name' => '2021-2022 Bball season'],
                        ['id' => '4', 'name' => '2022-2023 Bball season'],
                    ],
                    'active_season' => '4',
                ]
            ], 'message' => 'Successfully retrieved your league information'], HttpResponseCodes::HttpOK->value);

            return response()->json(['message' => "League successfully retrieved"]);
        } catch (NotFoundHttpException $e) {
            // Return 404 error for league not found
            return response()->json(['error' => 'League not found'], HttpResponseCodes::HttpNotFound->value);
        } catch (Exception $e) {
            return response()->json(['error' => $e], HttpResponseCodes::HttpInternalServerError->value);
        }
    }

    public function update(League $league, LeagueRequest $request): JsonResponse
    {
        try {
            $result = [
                'name' => $request->input('name'),
                'logo' => $request->input('logo'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description'),
                'primary_color' => $request->input('primary_color'),
                'secondary_color' => $request->input('secondary_color'),
                'sport' => $request->input('sport'),
                'owner_id' => $request->input('owner_id'),
                'organization_id' => $request->input('organization_id')
            ];

            $league->fill($result);
            $league->update($result);


            return response()->json(
                [
                    'league' => $league,
                    'message' => "League '{$league->name}' updated successfully"
                ],
                HttpResponseCodes::HttpOK->value
            );
        } catch (Exception $e) {
            return response()->json(['error' => "server error"]);
        }
    }

    //region - members

    //endregion- members

    //region - teams
    public function findTeams(): JsonResponse
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
    //endregion - teams
}
