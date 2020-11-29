<?php

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

Route::get('mutual-agreeable-date/{token}',function ($token) {
    return view('mutual_agreeable_date', compact('token'));
})->name('mad');
Route::post('mutual-agreeable-date/{token}', 'Api\EventArtistController@updateRepresentativeMad');
Route::get('/{vue_capture?}', function () {
    return view('index');
})->where('vue_capture', '.*');
