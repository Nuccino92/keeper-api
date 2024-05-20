<?php

namespace App\Http\Controllers\Payments;

use App\Enums\Api\HttpResponseCodes;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\League;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function index()
    {
    }


    public function createIntent(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Un authenticated'], HttpResponseCodes::HttpForbidden->value);
        }

        $setupIntent = $user->createSetupIntent();


        return response()->json(['data' => ['client_secret' => $setupIntent->client_secret, 'payment_method' => $setupIntent->payment_method, "status" => $setupIntent->status], "message" => "Created Intent"], HttpResponseCodes::HttpOK->value);
    }

    //League $league
    public function subscribeToLeague(Request $request): JsonResponse
    {
        Log::info('Request data:', $request->all());

        $request->validate([
            'payment_method_id' => 'required|string',
        ]);
        $payment_method_id = $request->input('payment_method_id');

        /** @var User $user */
        $user = auth()->user();

        $subscription = $user->newSubscription('prod_Py0hNRT8USBZ8x', 'price_1P87G2DVtWywKa8jLyxYKqzv')->create($payment_method_id);

        $subscription->update(['league_id' => 3]);

        //todo: return org/league id's

        return  response()->json(['message' => "done"], HttpResponseCodes::HttpOK->value);
    }
}


// default === product id
// price_monthly === price id
// ->newSubscription('default', 'price_monthly')
// ->allowPromotionCodes()
// ->checkout();