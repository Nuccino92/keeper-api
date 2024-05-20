<?php

namespace App\Http\Middleware;

use App\Enums\AccessEnum;
use App\Enums\Api\HttpResponseCodes;
use Closure;
use App\Models\League;
use App\Models\Organization;
use Illuminate\Http\Request;

class CheckProductAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = auth()->user();


        $type = $request->route('league') ? 'league' : 'organization';

        if ($type === 'league') {
            $model = $request->route('league');
        } else {
            $model = $request->route('organization');
        }

        /**
         * @TODO: must add/check for roles
         */
        if (!$model->isOwner($user)) {
            return response()->json(['error' => AccessEnum::UNAUTHORIZED], HttpResponseCodes::HttpForbidden->value);
        }

        if ($model && $model->subscription && $model->subscription->ends_at <= now()) {
            return response()->json(['error' => AccessEnum::INACTIVE, 'owner_id' => $user->id], HttpResponseCodes::HttpForbidden->value);
        }

        return $next($request);
    }
}
