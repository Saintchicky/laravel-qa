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
Route::post('/token','Auth\LoginController@getToken');
Route::get('/questions','Api\QuestionsController@index');
/*So by doing this way we no longer need to define new routes
when we working with other endpoints such as update or delete question.*/
// Route middleware protège cette route accessible uniquement que si on est loggé
Route::middleware(['auth:api'])->group(function() {
    Route::apiResource('/questions', 'Api\QuestionsController')->except('index');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
