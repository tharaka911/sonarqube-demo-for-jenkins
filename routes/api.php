<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PowerballResultController;
use App\Http\Controllers\BalancingController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\DhBetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * Get Poweball result - playlist ID, Track ID
 */

Route::get('livepowerball_result/{playlistID}/{trackID}', [PowerballResultController::class , 'getPlaylistTrackResult']);

Route::post('/balancing/betting/father', [BalancingController::class , 'balancing']);

Route::post('/balancing/betting/feed', [BalancingController::class , 'balancingFatherData']);

Route::post('/balancing/betting/specific', [BalancingController::class , 'balancingSpecific']);

//api call

Route::get('/live/result/{gametype}', [BalancingController::class , 'bepikAPI']);

//Change status
Route::get('/maintain/{game_type}/{type}/{maintain_status}/{maintain_type}', [MaintenanceController::class , 'updateMaintain']);

Route::get('/maintain/{game_type}/{type}', [MaintenanceController::class , 'getMaintain']);

//Add mising data
// Route::get('/missing', [MaintenanceController::class , 'missingData']);

//Dh
Route::post('/powerball/post', [DhBetController::class , 'create']);
Route::get('/powerball/get/{day}', [DhBetController::class , 'dayData']);
Route::get('/powerball/getlast', [DhBetController::class , 'latestBall']);
Route::get('/powerball/get_round/{id}', [DhBetController::class , 'roundId']);