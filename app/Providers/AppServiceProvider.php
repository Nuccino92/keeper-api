<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use App\Models\Cashier\Subscription;
use Stripe\Stripe;

// use App\Models\Cashier\SubscriptionItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Stripe::setApiKey(config('cashier.secret'));
        Cashier::useSubscriptionModel(Subscription::class);
        // Cashier::useSubscriptionItemModel(SubscriptionItem::class);
    }
}
