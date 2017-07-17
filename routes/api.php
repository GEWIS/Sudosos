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
    Route::post('products', 'ProductController@store');
    Route::get('products/{id}', 'ProductController@getProduct');
    Route::put('products/{id}', 'ProductController@putProduct');
    Route::delete('products/{id}', 'ProductController@deleteProduct');
    Route::put('products/{id}/reinstate', 'ProductController@reinstateProduct');
    Route::get('products/{id}/{property}', 'ProductController@getProductProperty');
    Route::put('products/{id}/{property}', 'ProductController@postProductProperty');
    
    Route::get('pointsofsale', 'PointOfSaleController@index');
    Route::post('pointsofsale', 'PointOfSaleController@store');
    Route::get('pointsofsale/{id}', 'PointOfSaleController@getPointOfSale');
    Route::put('pointsofsale/{id}', 'PointOfSaleController@putPointOfSale');
    Route::delete('pointsofsale/{id}', 'PointOfSaleController@deletePointOfSale');
    Route::put('pointsofsale/{id}/reinstate', 'PointOfSaleController@reinstatePointOfSale');
    Route::get('pointsofsale/{id}/{property}', 'PointOfSaleController@getPointOfSaleProperty');
    Route::put('pointsofsale/{id}/{property}', 'PointOfSaleController@putPointOfSaleProperty');


});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
