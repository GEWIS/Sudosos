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

Route::group(['namespace' => 'Web', 'middleware' => ['web']], function () {
    Route::get('/', 'IndexController@index');
});

Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'middleware' => ['web']], function () {
    Route::get('login', ['as' => 'login', 'uses' => 'LoginController@index']);
    Route::get('login/gewis', 'LoginController@showGEWISLogin');
    Route::get('login/gewis-done', 'LoginController@doGEWISLogin');
    Route::get('login/external', 'LoginController@showExternalLogin');
    Route::post('login/external', 'LoginController@doExternalLogin');
    Route::get('register', 'RegisterController@showRegister');
    Route::post('register', 'RegisterController@doRegister');

});
Route::any('{catchall}', function () {
    return Redirect::to('/');
})->where('catchall', '.*');