<?php

namespace App\Http\Controllers\ControlPanel;

use App\Enums\Api\HttpResponseCodes;
use App\Enums\MemberRoleEnum;
use App\Enums\RolePermissionsEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\League\LeagueRequest;
use App\Models\League;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ControlPanelController extends Controller
{
    public function index(League $league): JsonResponse
    {
        //1. IF LEAGUE->OWNER_ID === REQUEST ID, SEND ALL PERMISSIONS, BYPASS CHECK
        //2. Look up league_roles, find role, if role is super admin/ admin return set permissions..
        //3. IF 1,2 arent fullfilled look up league_permissions and get permissions

        //check if the strategy to only add entries to league_permissions/permissions if they are lower than an admin is a good strategy

        /**
         * Used for front end testing purposes
         */
        $missingSeasons = ['all_seasons' => [], 'active_season_id' => null];
        $withSeasons = [
            'all_seasons' => [
                ['id' => 1, 'name' => '2019-2020 Bball season'],
                ['id' => 2, 'name' => '2020-2021 Bball season'],
                ['id' => 3, 'name' => '2021-2022 Bball season'],
                ['id' => 4, 'name' => '2022-2023 Bball season'],
            ],
            //set as
            'active_season_id' => 4,
        ];
        $withithoutActiveSeason = [
            'all_seasons' => [
                ['id' => 1, 'name' => '2019-2020 Bball season'],
                ['id' => 2, 'name' => '2020-2021 Bball season'],
                ['id' => 3, 'name' => '2021-2022 Bball season'],
                ['id' => 4, 'name' => '2022-2023 Bball season'],
            ],
            //set as
            'active_season_id' => null,
        ];

        // TODO: create factory, when saving a super-admin/admin. auto create/update the permissions. cant adjust permissions with these roles (owner, super, admin)
        $ownerRole = ['role_name' => MemberRoleEnum::Owner, 'permissions' => [
            RolePermissionsEnum::MANAGE_LEAGUE => ['scope' => []],
            RolePermissionsEnum::EDIT_LEAGUE_INFO => ['scope' => []],
            RolePermissionsEnum::MANAGE_PLAYERS => ['scope' => []],
            RolePermissionsEnum::MANAGE_PAYMENTS => ['scope' => []],
            RolePermissionsEnum::MANAGE_NEWS => ['scope' => []],
            RolePermissionsEnum::MANAGE_SCHEDULE => ['scope' => []],
            RolePermissionsEnum::MANAGE_SEASONS => ['scope' => []],
            RolePermissionsEnum::MANAGE_ROSTER => ['scope' => []],
            RolePermissionsEnum::MANAGE_TEAMS => ['scope' => []],
        ]];

        $superAdminRole = ['role_name' => MemberRoleEnum::SuperAdmin, 'permissions' => [
            RolePermissionsEnum::EDIT_LEAGUE_INFO => ['scope' => []],
            RolePermissionsEnum::MANAGE_PLAYERS => ['scope' => []],
            RolePermissionsEnum::MANAGE_PAYMENTS => ['scope' => []],
            RolePermissionsEnum::MANAGE_NEWS => ['scope' => []],
            RolePermissionsEnum::MANAGE_SCHEDULE => ['scope' => []],
            RolePermissionsEnum::MANAGE_SEASONS => ['scope' => []],
            RolePermissionsEnum::MANAGE_ROSTER => ['scope' => []],
            RolePermissionsEnum::MANAGE_TEAMS => ['scope' => []],
        ]];

        $adminRole = ['role_name' => MemberRoleEnum::Admin, 'permissions' => [
            RolePermissionsEnum::MANAGE_PLAYERS => ['scope' => []],
            RolePermissionsEnum::MANAGE_PAYMENTS => ['scope' => []],
            RolePermissionsEnum::MANAGE_NEWS => ['scope' => []],
            RolePermissionsEnum::MANAGE_SCHEDULE => ['scope' => []],
            RolePermissionsEnum::MANAGE_SEASONS => ['scope' => []],
            RolePermissionsEnum::MANAGE_ROSTER => ['scope' => []],
            RolePermissionsEnum::MANAGE_TEAMS => ['scope' => []],
        ]];

        $memberRole = ['role_name' => MemberRoleEnum::Member, 'permissions' => [
            RolePermissionsEnum::MANAGE_ROSTER => ['scope' => []],
            RolePermissionsEnum::MANAGE_TEAMS => ['scope' => [1, 5]],
        ]];

        $playerRole = ['role_name' => MemberRoleEnum::Player, 'permissions' => []];

        try {
            return response()->json(['data' => [
                'league_info' => $league,
                'seasons' => $withSeasons,
                'role' => $ownerRole,
            ], 'message' => 'Successfully retrieved your league information'], HttpResponseCodes::HttpOK->value);

            return response()->json(['message' => 'League successfully retrieved']);
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
                'organization_id' => $request->input('organization_id'),
            ];

            $league->fill($result);
            $league->update($result);

            return response()->json(
                [
                    'league' => $league,
                    'message' => "League '{$league->name}' updated successfully",
                ],
                HttpResponseCodes::HttpOK->value
            );
        } catch (Exception $e) {
            return response()->json(['error' => 'server error']);
        }
    }

    public function generateGamesSchedule(League $league): JsonResponse
    {
        //TODO: handle an odd number of teams. 
        try {
            // Check league seasons, find active season. if has active season generate schedule, if not throw error

            usleep(3200000); // 400,000 microseconds = 400ms

            return response()->json(
                [
                    'message' => "Schedule generated successfully",
                ],
                HttpResponseCodes::HttpOK->value
            );
        } catch (Exception $e) {
            return response()->json(['error' => $e]);
        }
    }
}
