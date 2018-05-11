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

Route::get("/reviews/", "ReviewsController@index")->name("ReviewsIndex");
Route::get("/reviews/import/", "ReviewsController@import")->middleware("auth")->name("ReviewsImportIndex");
Route::post("/reviews/import/send/", "ReviewsController@importHandler")->middleware("auth")->name("ReviewsImportSend");

Route::get("/news/", "NewsController@index")->name("NewsIndex");
Route::get("/news/{code}", "NewsController@show")->name("NewsShow");
Route::get("/news/import/", "NewsController@import")->middleware("auth")->name("NewsImportIndex");
Route::post("/news/import/send/", "NewsController@importHandler")->middleware("auth")->name("NewsImportSend");

Route::get("/blog/", "BlogController@index")->name("BlogIndex");
Route::get("/blog/{code}", "BlogController@show")->name("BlogShow");
Route::get("/blog/import/", "BlogController@import")->middleware("auth")->name("BlogImportIndex");
Route::post("/blog/import/send/", "BlogController@importHandler")->middleware("auth")->name("BlogImportSend");

Route::get("/builders/", "BuildersController@index")->name("BuildersIndex");
Route::get("/builders/{code}", "BuildersController@show")->name("BuildersShow");
Route::get("/builders/import/", "BuildersController@import")->middleware("auth")->name("BuildersImportIndex");
Route::post("/builders/import/send/", "BuildersController@importHandler")->middleware("auth")->name("BuildersImportSend");

Route::get("/partners/", "PartnersController@index")->name("PartnersIndex");
Route::get("/partners/import/", "PartnersController@import")->middleware("auth")->name("PartnersImportIndex");
Route::post("/partners/import/send/", "PartnersController@importHandler")->middleware("auth")->name("PartnersImportSend");

Route::get("/company/team/", "TeamController@index")->name("TeamIndex");
Route::get("/company/team/import/", "TeamController@import")->middleware("auth")->name("TeamImportIndex");
Route::post("/company/team/import/send/", "TeamController@importHandler")->middleware("auth")->name("TeamImportSend");

Route::get("/catalog/", "CatalogController@index")->name("CatalogIndex");
Route::get("/catalog/{section}/", "CatalogController@section")->name("CatalogSection");

Route::get("/catalog/{section}/filter/{params}/", "CatalogController@section")->name("CatalogSectionFilter")->where(["params" => "([/A-Za-z0-9_-]+)"]);

Route::get("/catalog/{section}/{subsection}/", "CatalogController@subsection")->name("CatalogSubSection");
Route::get("/catalog/{section}/{subsection}/{code}/", "CatalogController@show")->name("CatalogShow");
Route::get("/catalog/import/", "CatalogController@import")->middleware("auth")->name("CatalogImportIndex");
Route::post("/catalog/import/send/", "CatalogController@importHandler")->middleware("auth")->name("CatalogImportSend");

Route::get("/contacts/", "ContactsController@index")->name("ContactsIndex");

Route::get("/vacancies/", "VacanciesController@index")->name("VacanciesIndex");

Route::get("/company/about/", "AboutController@index")->name("AboutIndex");

Route::get("/company/", function () {
    return redirect("/company/about/");
})->name("CompanyIndex");

Route::get("/about/", function () {
    return redirect("/company/about/");
})->name("CompanyIndex");

//Route::get("/company/about/", ["uses" => "PageController@default", "arParams" => [
//	"view" => "test"
//]]);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
