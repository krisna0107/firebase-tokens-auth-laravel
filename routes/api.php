<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('login', function (Request $request) {
    return "eaaa";
});


Route::post('/tokens', 'AuthTesting@index');

// Route::get('/me', function (Request $request) {
//     return (array) $request->user();
// })->middleware('auth:api');

// Route::get('login', function (Request $request) {
//     return (array) $request->user();
// })->middleware('auth:api');
Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function(){
    Route::get('/me', function () {
        return "Carol Sayang";
    });
});
