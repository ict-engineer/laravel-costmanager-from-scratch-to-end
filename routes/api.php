<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/add-shop', 'Admin\ApiShopController@addShop');
Route::post('/get-shop', 'Admin\ApiShopController@getShopInfo');
Route::post('/edit-shop', 'Admin\ApiShopController@editShop');
Route::post('/delete-shop', 'Admin\ApiShopController@deleteShop');
Route::post('/add-material', 'Admin\ApiMaterialController@addMaterial');
Route::post('/get-material', 'Admin\ApiMaterialController@getMaterialInfo');
Route::post('/edit-material', 'Admin\ApiMaterialController@editMaterial');
Route::post('/delete-material', 'Admin\ApiMaterialController@deleteMaterial');