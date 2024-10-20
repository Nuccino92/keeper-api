<?php

namespace App\Enums;

class RolePermissionsEnum
{
    public const MANAGE_LEAGUE = 'manage_league'; // owner only (monthly sub end, delete league)
    public const EDIT_LEAGUE_INFO = 'edit_league_info'; // owner, super-admin only

    //TODO: possible add manage_player, manage_team roles so scope the player/team

    public const MANAGE_PLAYERS = 'manage_players'; // manage players
    public const MANAGE_PAYMENTS = 'manage_payments';
    public const MANAGE_NEWS = 'manage_news';
    public const MANAGE_SCHEDULE = 'manage_schedule';
    public const MANAGE_SEASONS = 'manage_seasons'; // (add season, delete season, set active season, add/remove teams from season)

    //Possibly change to MANAGE_SEASONS
    public const MANAGE_ROSTER = 'manage_roster'; // for season page
    public const MANAGE_TEAMS = 'manage_teams'; // change teams info, (scoped), if scoped only allow editing scoped teams
}
