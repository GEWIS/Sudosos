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
Route::group(['namespace' => 'Api\v1', 'prefix' => 'v1'], function () {

            Route::get('products', 'ProductController@index');
            Route::get('products/{id}', 'ProductController@getProduct');
            Route::post('products', 'ProductController@store');


});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
