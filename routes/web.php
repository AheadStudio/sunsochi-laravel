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

Route::get("/", "PageController@home");

Route::get("/company/about/", ["uses" => "PageController@default", "arParams" => [
	"view" => "test"
]]);
Route::get("/company/team/", "PageController@default");
Route::get("/reviews/", "PageController@default");
Route::get("/news/", "NewsController@getNews");
Route::get("/blog/", "BlogController@getBlog");
Route::get("/developers/", "PageController@default");
Route::get("/partners/", "PageController@default");
Route::get("/contacts/", "PageController@default");

Route::get("/catalog/", "CatalogController@index");
Route::get("/catalog/{section}/", "CatalogController@section");
Route::get("/catalog/{section}/{code}/", "CatalogController@detail");
Route::get("/investments/", "PageController@default");

// route for import table
//--- news ---//
Route::get("/news/import/", "NewsImportController@index")->name("index");
Route::post("/news/import/send/", "NewsImportController@import")->name("import");
//--- blogs ---//
Route::get("/blog/import/", "BlogImportController@index")->name("index");
Route::post("/blog/import/send/", "BlogImportController@import")->name("import");

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
