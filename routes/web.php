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
use App\Models\Product;
Route::get('/', function () {

        return Product::create([
            'category' => "Other",
            'owner_id' => 'Jane',
            'name' => 'john',
            'price' => '155',
            'image' => 'john@jane.com',
            'tray_size' => '2',
            'category' => 'john@jane.com',
            ]);
});
