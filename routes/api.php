<?php

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
Route::prefix('v1')->group(function () {
    Route::post('/oauth/token', [
        'uses' => '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken',
        'middleware' => 'throttle',
    ]);

    Route::middleware('auth:api')->namespace('Api')->group(function () {
        Route::resource('performance-locations', 'PerformanceLocationController');
        Route::resource('stages', 'StageController');
        Route::resource('artists', 'ArtistController');
        Route::resource('events', 'EventController');
        Route::resource('events_list', 'EventListController');
        Route::prefix('events/{id}')->group(function () {
            Route::resource('notes', 'EventNoteController');
            Route::resource('artists', 'EventArtistController');
            Route::resource('contacts', 'EventContactController');
            Route::resource('tasks', 'EventTaskController');
            Route::resource('activities', 'EventActivityController');
            Route::resource('expenses', 'EventExpenseController');
        });
    });
});

Route::any('{path}', function () {
    return response()->json(['status' => false], \Illuminate\Http\Response::HTTP_NOT_FOUND);
})->where('path', '.*');
