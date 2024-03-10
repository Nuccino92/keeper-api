<?php

use App\Http\Controllers\Auth\PassportAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [PassportAuthController::class, 'login']);
Route::post('/register', [PassportAuthController::class, 'register']);
Route::middleware(['auth:api'])->group(function () {
    Route::get('/auth', [PassportAuthController::class, 'auth']);
    Route::get('/logout', [PassportAuthController::class, 'logout']);
});
