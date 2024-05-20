<?php

namespace App\Lib;

use App\Models\League;
use App\Models\Organization;

class SlugHelper
{
    /**
     * Check if a slug exists for a given entity context.
     *
     * @param string $slug The slug to check.
     * @param string $context The context of the entity (e.g., 'league', 'organization').
     * @return bool True if the slug exists for the specified entity context, false otherwise.
     */
    public static function checkSlugExists($slug, $context)
    {
        switch ($context) {
            case 'league':
                return League::where('slug', $slug)->exists();
            case 'organization':
                return Organization::where('slug', $slug)->exists();
                // Add more cases for additional entities
            default:
                return false;
        }
    }
}
