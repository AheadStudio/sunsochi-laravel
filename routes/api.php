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

// blog API
Route::get("/blog/", "ApiController@getBlog");
Route::post("/blog/add-rating/", "ApiController@updateRating");

// catalog API
Route::get("/catalog/", "ApiController@getCatalog");
Route::get("/catalog/district/", "ApiController@getDistrict");
