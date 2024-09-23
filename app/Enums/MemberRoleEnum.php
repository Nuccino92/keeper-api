<?php

namespace App\Enums;

class MemberRoleEnum
{
    public const Owner = 'owner';
    public const SuperAdmin = 'super-admin';
    public const Admin = 'admin';
    public const Member = 'member';
    public const Player = 'player';
}

/**
 * Scopes
 * 
 * Owner:
 * - Everything
 * 
 * Super Admin:
 * - Everything except MANAGE_LEAGUE
 * 
 * Admin:
 * - Everything except MANAGE_LEAGUE, EDIT_LEAGUE_INFO
 * 
 * Member:
 * - Nothing until added. 
 * - If added EDIT_LEAGUE_INFO -> becomes Admin. 
 * - If added MANAGE_LEAGUE -> becomes Super Admin
 * 
 * Player:
 * - Only linked with a player in the league, nothing more. (used to allow users to connect with their player/league better)
 */
