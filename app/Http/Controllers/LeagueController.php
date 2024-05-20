<?php

namespace App\Http\Controllers;

use App\Enums\Api\HttpResponseCodes;
use App\Enums\Payments\TrialLengthEnum;
use App\Http\Requests\League\LeagueRequest;
use App\Http\Requests\League\UpdateLeagueRequest;
use App\Models\League;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\CardException;
use Stripe\Price;

class LeagueController extends Controller
{

    public function index(League $league)
    {
        //
    }

    /**
     * @param \App\Http\Requests\LeagueRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function create(LeagueRequest $request): JsonResponse
    {

        /** @var User $user */
        $user = auth()->user();

        try {
            $formData = $request->input('form_data');

            $result = [
                'name' => $formData['name'],
                'logo' => $formData['logo'],
                'slug' => $formData['slug'],
                'description' => $formData['description'],
                'primary_color' => $formData['primary_color'],
                'secondary_color' => $formData['secondary_color'],
                'owner_id' => $user->id,
                // 'organization_id' => $formData['organization_id'] ?? null,
                'organization_id' => null
            ];

            if ($request->input('subscription')) {
                $subscription = $request->input('subscription');

                $payment_method_id = $subscription['payment_method_id'];
                $product_id = $subscription['product_id'];
                $price_id = $subscription['price_id'];

                try {
                    $subscription = $user->newSubscription($product_id, $price_id)->create($payment_method_id);
                } catch (CardException $e) {
                    return response()->json(['error' => $e->getMessage()], HttpResponseCodes::HttpBadRequest->value);
                }

                $stripePrice = Price::retrieve($price_id, ['expand' => ['product']]);
                $stripePrice->refresh();

                $interval =  $stripePrice->recurring->interval;

                if ($interval === 'year') {
                    $endsAt = date('Y-m-d H:i:s', strtotime('+1 year'));
                }
                if ($interval === 'month') {
                    $endsAt = date('Y-m-d H:i:s', strtotime('+1 month'));
                }

                //  $endsAt = Carbon::now()->add($interval);

                $league = League::create($result);

                $subscription->update(['league_id' => $league->id, 'ends_at' => $endsAt]);

                return response()->json(
                    [
                        'league' => ['league' => $league],
                        'message' => 'League successfully created'
                    ],
                    HttpResponseCodes::HttpOK->value
                );
            }

            if ($user->trial_ends_at === null) {
                $user->update(['trial_ends_at' => now()->addDays(TrialLengthEnum::LEAGUE_SHORT)]);
                $league = League::create($result);

                return response()->json(
                    [
                        'league' => ['message' => "League has been created and is active", 'league_id' => $league->id],
                        'message' => 'League successfully created'
                    ],
                    HttpResponseCodes::HttpOK->value
                );
            } else {
                return response()->json(['message' => 'The free trial has already been activated'], HttpResponseCodes::HttpForbidden->value);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'server error', $e], HttpResponseCodes::HttpInternalServerError->value);
        }
    }

    /**
     * @param \App\Models\League $league
     * @param \App\Http\Requests\LeagueRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(League $league, UpdateLeagueRequest $request): JsonResponse
    {
        try {
            $result = [
                'name' => $request->input('name'),
                'logo' => $request->input('logo'),
                'description' => $request->input('description'),
                'primary_color' => $request->input('primary_color'),
                'secondary_color' => $request->input('secondary_color'),
            ];

            $league->fill($result);
            $league->update($result);

            // TODO: check if there is a subscription

            // $request->validate([
            //     'payment_method_id' => 'required|string',
            // ]);
            // $payment_method_id = $request->input('payment_method_id');

            // /** @var User $user */
            // $user = auth()->user();

            // $subscription = $user->newSubscription('prod_Py0hNRT8USBZ8x', 'price_1P87G2DVtWywKa8jLyxYKqzv')->create($payment_method_id);

            // $subscription->update(['league_id' => 3]);

            return response()->json(
                [
                    'league' => $league,
                    'message' => "League '{$league->name}' updated successfully"
                ],
                HttpResponseCodes::HttpOK->value
            );
        } catch (Exception $e) {
            Log::error('Server Error: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            return response()->json(['error' => "server error"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
