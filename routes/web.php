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
Route::get("/reviews/", "ReviewsController@list");
Route::get("/reviews/import/", "ReviewsController@import")->middleware("auth")->name("ReviewsImportIndex");
Route::post("/reviews/import/send/", "ReviewsController@importHandler")->middleware("auth")->name("ReviewsImportSend");

Route::get("/news/", "NewsController@list");
Route::get("/news/import/", "NewsController@import")->middleware("auth")->name("NewsImportIndex");
Route::post("/news/import/send/", "NewsController@importHandler")->middleware("auth")->name("NewsImportSend");

Route::get("/blog/", "BlogController@list");
Route::get("/blog/import/", "BlogController@import")->middleware("auth")->name("BlogImportIndex");
Route::post("/blog/import/send/", "BlogController@importHandler")->middleware("auth")->name("BlogImportSend");

Route::get("/builders/", "BuildersController@list");
Route::get("/builders/import/", "BuildersController@import")->middleware("auth")->name("BuildersImportIndex");
Route::post("/builders/import/send/", "BuildersController@importHandler")->middleware("auth")->name("BuildersImportSend");

Route::get("/partners/", "PartnersController@list");
Route::get("/partners/import/", "PartnersController@import")->middleware("auth")->name("PartnersImportIndex");
Route::post("/partners/import/send/", "PartnersController@importHandler")->middleware("auth")->name("PartnersImportSend");

Route::get("/company/team/", "TeamController@list");
Route::get("/company/team/import/", "TeamController@import")->middleware("auth")->name("TeamImportIndex");
Route::post("/company/team/import/send/", "TeamController@importHandler")->middleware("auth")->name("TeamImportSend");

Route::get("/contacts/", "PageController@default");

Route::get("/catalog/", "CatalogController@index");
Route::get("/catalog/{section}/", "CatalogController@section");
Route::get("/catalog/{section}/{code}/", "CatalogController@detail");
Route::get("/investments/", "PageController@default");


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
