<?php
use App\Http\Middleware;
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

// All routes when logged in to the adminpanel
Route::group(['namespace' => 'Web', 'middleware' => ['auth:web']], function () {
    Route::get('/', 'IndexController@index');
});
/**
 * Alle routes for guests
 */
Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'middleware' => ['guest']], function () {
    Route::get('login', ['as' => 'login', 'uses' => 'LoginController@index']);
    Route::post('login', 'LoginController@doExternalLogin');
    Route::get('login/gewis', 'LoginController@showGEWISLogin');
    Route::get('login/gewis-done', 'LoginController@doGEWISLogin');

    Route::get('register', 'RegisterController@showRegister');
    Route::post('register', 'RegisterController@doRegister');
});