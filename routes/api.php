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
    Route::put('products/{id}/{property}', 'ProductController@putProductProperty');
    
    Route::get('pointsofsale', 'PointOfSaleController@index');
    Route::post('pointsofsale', 'PointOfSaleController@store');
    Route::get('pointsofsale/{id}', 'PointOfSaleController@getPointOfSale');
    Route::put('pointsofsale/{id}', 'PointOfSaleController@putPointOfSale');
    Route::delete('pointsofsale/{id}', 'PointOfSaleController@deletePointOfSale');
    Route::put('pointsofsale/{id}/reinstate', 'PointOfSaleController@reinstatePointOfSale');
    Route::get('pointsofsale/{id}/{property}', 'PointOfSaleController@getPointOfSaleProperty');
    Route::put('pointsofsale/{id}/{property}', 'PointOfSaleController@putPointOfSaleProperty');

    Route::get('storages', 'StorageController@index');
    Route::post('storages', 'StorageController@store');
    Route::get('storages/{id}', 'StorageController@getStorage');
    Route::put('storages/{id}', 'StorageController@putStorage');
    Route::delete('storages/{id}', 'StorageController@deleteStorage');
    Route::put('storages/{id}/reinstate', 'StorageController@reinstateStorage');
    Route::get('storages/{id}/{property}', 'StorageController@getStorageProperty');
    Route::put('storages/{id}/{property}', 'StorageController@postStorageProperty');
    Route::get('storages/{id}/stores', 'StorageController@getStorageProduct');
    Route::get('storages/{storage_id}/stock/{product_id}','StorageController@getStorageOfProduct');
    Route::put('storages/{storage_id}/stock/{product_id}','StorageController@putStorageOfProduct');
    Route::put('storages/{storage_id}/stores/{product_id}','StorageController@putStorageProduct');
    Route::delete('storages/{storage_id}/stores/{product_id','StorageController@deleteStorageProduct');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
