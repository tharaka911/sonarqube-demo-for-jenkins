<?php

use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\VideoTypesController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\PlaylistTrackController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiManagementController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register'=> false
]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/api_management', 'ApiManagementController@index');
Route::get('/delete/apikey/{id}', 'ApiManagementController@delete');
Route::post('/create/apikey', 'ApiManagementController@create');

Route::get('/prochart-game-results', 'GameResultsController@index');

Route::get('/sample', function () {
    return view('dashboard.sample');
});


//Game Results admin
Route::get('/game/vivace-chart', 'GameResultsController@indexVivaceChart');
Route::post('/create/adminData', 'GameResultsController@createAdminData');



Route::get('/game/neonladder', 'GameResultsController@indexLadder');
Route::get('/game/neoncard', 'GameResultsController@indexCard');
Route::get('/game/powerball', 'GameResultsController@indexPowerball');

//Create Future Game Reuslts
Route::post('/future/speedLadder', 'GameResultsController@createFutureResultSpeedLadder')->name('future.speedLadder');
Route::post('/future/neonCard', 'GameResultsController@createFutureResultNeonCard')->name('future.neonCard');
Route::post('/future/powerball', 'GameResultsController@createFutureResultPowerball')->name('future.powerball');


//Delete Future Game results
Route::get('/delete/future/result/{gameId}', 'GameResultsController@deleteFutureResult');
Route::get('/delete/neonladder/result/{gameId}', 'GameResultsController@deleteNeonLadder');
Route::get('/delete/neoncard/result/{gameId}', 'GameResultsController@deleteNeonCard');


Route::get('/logout', 'HomeController@logout');
Route::get('/pass_reset','UserController@passReset');


//Generate Game Results
Route::get('/ladder_game_results', 'GameResultsController@generateLadderGameResult');
Route::get('/powerball_game_results', 'GameResultsController@generatePowerballGameResult');
Route::get('/racing_game_results', 'GameResultsController@generateRacingGameResult');




//Sync Game Results
Route::get('/ladder_game_results_sync', 'GameResultsController@generateLadderGameResultSync');
Route::get('/powerball_game_results_sync', 'GameResultsController@generatePowerballGameResultSync');

Route::get('/game_results_sync', 'GameResultsController@generateGameResultSync');



//Get Server Time
Route::get('/get_server_time', 'GameResultsController@getServerTime');


//Game Config
Route::get('/game_config', 'GameResultsController@gameConfig');


//Games View
Route::get('/ladder', 'GameResultsController@webLadder');


Route::get('/powerball', function () {
    return view('games.powerball');
});

//Game Types
//Route::get('/dashbord/videotype3', [VideoTypesController::class, 'view_1'])->name('dashboard.videotype3');
//Route::get('/video_handle', 'VideoListController@videoHandler')->name('dashboard.video_handler');
Route::get('/video_list/{type}', 'VideoListController@index');
// Route::get('/video_type/3min', 'VideoListController@listThreeMinVideos')->name('dashboard.video_type3');
// Route::get('/video_type/5min', 'VideoListController@listFiveMinVideos')->name('dashboard.video_type5');
//Route::get('/video_playlists/{type}', 'PlaylistController@index');

Route::get('/search', 'PlaylistController@search')->name('search');
Route::get('/search_5min', 'PlaylistController@search_5min')->name('search_5min');

//Command Script Runner
Route::get('/test_python', 'CommandController@testPythonScript');
Route::get('/collect_media_files', 'CommandController@collectMediaFiles');
Route::get('/create_playlist_xml', 'CommandController@createPlayListXML');


//Playlist
Route::get('/playlist/{type}', 'PlaylistController@index');
Route::post('/playlist', 'PlaylistController@create');
Route::get('/delete/playlist/{id}', 'PlaylistController@delete');

Route::get('/playlist_video', 'VideoListController@videoHandler')->name('dashboard.video_handler');

//PlaylistTrack
Route::get('/playlist_track/{playlistID}', 'PlaylistTrackController@index');
Route::post('/playlist_track', 'PlaylistTrackController@generateRandomVideoTracks');
Route::post('/playlist_track_regenerate', 'PlaylistTrackController@regeneratePlaylistTracks');
Route::post('/change_playlist_track', 'PlaylistTrackController@replaceVideoTrack');
Route::post('/change_playlist_track_by_filter', 'PlaylistTrackController@replaceVideoTrackByFilter');

Route::post('/videolist_update_command', 'VideoListController@videoListUpdateCommand');
Route::get('/delete/video_file/{video_id}/{type}', 'VideoListController@delete');


Route::get('/show_csrf_token', 'HomeController@showToken');

Route::get('/clear-cache-all', function() {
    Artisan::call('cache:clear');

    dd("Cache Clear All");
});

// Route::get('/test_result', 'PlaylistTrackController@testResult');

Route::get('/test_result/{playlistID}/{trackID}', 'PowerballResultController@getPlaylistTrackResult');

// ------------Localization routes----------------
Route::get('/lang/change', [LocalizationController::class, 'change'])->name('changeLang');

/**
 * Balancing route
 */
Route::get('/balancing/{type}', 'BalancingController@index');

Route::get('/balancing/add/test', 'BalancingController@addView');

Route::get('/balancing/update/{balance}/{type}', 'BalancingController@update');

//Route::post('/balancing/betting/feed', 'BalancingController@balancing');

Route::post('/balancing/result/filter', 'BalancingController@filterByDate');

Route::get('/balancing_data/{type}', 'BalancingController@sendBalancingData');

Route::get('/check_ip', 'BalancingController@checkIP');

Route::get('/father_site_balancing/{type}', 'BalancingController@fatherSiteBalancing');

Route::post('/check-password', 'PlaylistController@password_check');

//Maintain route

Route::get('/maintain_settings', 'MaintenanceController@maintenance');

//Missing data add route
Route::get('/missing/{type}', 'MissingDataController@show');

?>
