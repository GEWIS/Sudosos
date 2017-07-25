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

Route::group(['middleware'=> 'auth', 'namespace' => 'Api\v1', 'prefix' => 'v1'], function () {
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
    Route::get('storages/{id}/stores', 'StorageController@getStorageProducts');
    Route::get('storages/{id}/{property}', 'StorageController@getStorageProperty');
    Route::put('storages/{id}/{property}', 'StorageController@postStorageProperty');
    Route::get('storages/{storage_id}/stock/{product_id}','StorageController@getStorageStockOfProduct');
    Route::put('storages/{storage_id}/stock/{product_id}','StorageController@putStorageStockOfProduct');
    Route::post('storages/{storage_id}/stores/{product_id}','StorageController@postStorageProduct');
    Route::delete('storages/{storage_id}/stores/{product_id}','StorageController@deleteStorageProduct');

    Route::get('roles', 'RBACController@getRoles');
    Route::get('roles/{id}', 'RBACController@getRole');
    Route::post('roles', 'RBACController@createRole');
    Route::put('roles/{id}', 'RBACController@updateRole');
    Route::delete('roles/{id}', 'RBACController@deleteRole');
    Route::put('roles/{id}/reinstate', 'RBACController@reinstateRole');
    Route::post('roles/{role_id}/assign/{user_id}', 'RBACController@addRoleToUser');
    Route::delete('roles/{role_id}/remove/{user_id}', 'RBACController@removeRoleFromUser');

    Route::get('permissions','RBACController@getPermissions');
    Route::post('permissions/{permission_id}/assign/{role_id}', 'RBACController@addPermissionToRole');
    Route::delete('permissions/{permission_id}/remove/{role_id}','RBACController@removePermissionFromRole');
});