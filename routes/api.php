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

    Route::get('products/owner/{owner_id}', 'ProductController@index');
    Route::post('products', 'ProductController@store');
    Route::get('products/{id}', 'ProductController@getProduct');
    Route::put('products/{id}', 'ProductController@putProduct');
    Route::delete('products/{id}', 'ProductController@deleteProduct');
    Route::put('products/{id}/reinstate', 'ProductController@reinstateProduct');
    Route::get('products/{id}/{property}', 'ProductController@getProductProperty');
    Route::put('products/{id}/{property}', 'ProductController@putProductProperty');

    Route::get('pointsofsale/owner/{owner_id}', 'PointOfSaleController@index');
    Route::post('pointsofsale/owner', 'PointOfSaleController@store');
    Route::get('pointsofsale/{id}', 'PointOfSaleController@getPointOfSale');
    Route::put('pointsofsale/{id}', 'PointOfSaleController@putPointOfSale');
    Route::delete('pointsofsale/{id}', 'PointOfSaleController@deletePointOfSale');
    Route::put('pointsofsale/{id}/reinstate', 'PointOfSaleController@reinstatePointOfSale');
    Route::get('pointsofsale/{id}/{property}', 'PointOfSaleController@getPointOfSaleProperty');
    Route::put('pointsofsale/{id}/{property}', 'PointOfSaleController@putPointOfSaleProperty');
    Route::post('pointsofsale/{pos_id}/stores/{storage_id}', 'PointOfSaleController@postStoragePointsOfSale');
    Route::delete('pointsofsale/{pos_id}/stores/{storage_id}', 'PointOfSaleController@deleteStoragePointsOfSale');

    Route::get('storages/owner/{owner_id}', 'StorageController@index');
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

    Route::get('transactions', 'TransactionController@index');
    Route::get('transactions/{id}', 'TransactionController@getTransaction');
    Route::get('transactions/activity/{id}', 'TransactionController@getByActivity');
    Route::post('transactions', 'TransactionController@createTransaction');
    Route::delete('transactions/{id}', 'TransactionController@deleteTransaction');
    Route::get('transactions/user/{id}', 'TransactionController@getTransactionOfUser');
    Route::post('transactions/{transaction_id}/subtransactions','SubtransactionController@createSubtransaction');

    Route::get('roles', 'RBACController@getRoles');
    Route::get('roles/{id}', 'RBACController@getRole');
    Route::post('roles', 'RBACController@createRole');
    Route::put('roles/{id}', 'RBACController@updateRole');
    Route::delete('roles/{id}', 'RBACController@deleteRole');
    Route::get('roles/{id}/permissions', 'RBACController@getPermissionFromRoles');
    Route::put('roles/{id}/reinstate', 'RBACController@reinstateRole');
    Route::post('roles/{role_id}/assign/{user_id}', 'RBACController@addRoleToUser');
    Route::delete('roles/{role_id}/remove/{user_id}', 'RBACController@removeRoleFromUser');

    Route::get('roles/owner/{owner_id}', 'RBACController@getRoles');
    Route::get('permissions','RBACController@getPermissions');
    Route::post('permissions/{permission_id}/assign/{role_id}', 'RBACController@addPermissionToRole');
    Route::delete('permissions/{permission_id}/remove/{role_id}','RBACController@removePermissionFromRole');
});