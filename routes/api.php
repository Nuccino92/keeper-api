<?php

use App\Http\Controllers\Auth\PassportAuthController;
use App\Http\Controllers\ControlPanelController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\Payments\ProductController;
use App\Http\Controllers\Payments\SubscriptionController;
use App\Http\Controllers\SlugController;
use App\Http\Middleware\CheckProductAccess;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


/**
 * Region - Auth routes
 */
Route::post('/login', [PassportAuthController::class, 'login']);
Route::post('/register', [PassportAuthController::class, 'register']);
Route::middleware(['auth:api'])->group(function () {
    Route::get('/auth', [PassportAuthController::class, 'auth']);
    Route::get('/logout', [PassportAuthController::class, 'logout']);
    // Route::put('/update-profile', [])
});
/**
 * End Region 
 */

/**
 * Region - Payments  
 */

Route::middleware((['auth:api']))->group(function () {
    Route::prefix('payments')->middleware(['auth:api'])->group(function () {

        Route::post('/createSetupIntent', [SubscriptionController::class, 'createIntent']);
        Route::post('/test-sub', [SubscriptionController::class, 'subscribeToLeague']);

        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/prices', [ProductController::class, 'prices']);

        Route::get('/products/{product}', [ProductController::class, 'product']);
        Route::get('/prices/{price}', [ProductController::class], 'price');

        Route::get('products-with-prices', [ProductController::class, 'productsWithPrices']);
    });
});



/**
 * End Region
 */



Route::middleware(['auth:api'])->group((function () {
    /**
     * Region - League
     */
    Route::prefix('league')->group(function () {
        Route::get('/{league}', [LeagueController::class, 'index']);
        Route::post('/', [LeagueController::class, 'create']);

        Route::put('/{league}', [LeagueController::class, 'update'])->middleware([CheckProductAccess::class]);

        Route::prefix('subscribe')->group(function () {
            Route::post('/{league}', [SubscriptionController::class, 'subscribeToLeague']);
        });
    });
    /**
     * End Region - League
     */

    /**
     * Region - Organization
     */
    Route::prefix('organization')->group(function () {
        // Route::get('/', []);
        //create OrganizationController
        Route::post('/', [LeagueController::class, 'create']);
        //create OrganizationController
        Route::put('/{organization}', [LeagueController::class, 'update']);

        Route::prefix('subscribe')->group(function () {
            Route::post('/{organization}', [SubscriptionController::class, 'subscribeToLeague']);
        });
    });
    /**
     * End Region - Organization
     */

    /**
     * Region - Slug
     */
    Route::prefix('slug')->group(function () {
        Route::get('/check-unique', [SlugController::class, 'checkUnique']);
        Route::post('/generate', [SlugController::class, 'generateSlug']);
    });
    /**
     * End Region - Slug
     */

    /**
     * Region - Control Panel Routes
     */
    Route::prefix('control-panel')->group(function () {
        //region
        Route::prefix('league')->group(function () {
            Route::middleware([CheckProductAccess::class])->group(function () {
                Route::get('/{league}', [ControlPanelController::class, 'index']);

                Route::prefix('members')->group(function () {
                });

                Route::prefix('teams')->group(function () {
                    Route::get('', [ControlPanelController::class, 'findTeams']);
                    Route::put('/{team}', [ControlPanelController::class, 'updateTeam']);
                    Route::delete('/{team}', [ControlPanelController::class, 'deleteTeam']);
                });

                Route::prefix('players')->group(function () {
                });
            });
        });
        //endregion

        //region
        Route::prefix('organization')->group(function () {
            Route::get('/{organization}', []);
        });
        //endregion
    });
    /**
     * End Region - Control Panel Routes
     */
}));


/**
 * Region - League Website Routes  
 */



/**
 * End Region
 */
