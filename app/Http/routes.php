<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', "Frontend\HomeController@index");

Route::get('manager/auth/login', "Manager\Auth\AuthController@getLogin");
Route::post('manager/auth/login', "Manager\Auth\AuthController@postLogin");


/*
  Route::get("/searcher/auto/feed/productions","AutoUpdateSearcherController@productions_feed");
  Route::get("/searcher/auto/track/production/{take}","AutoUpdateSearcherController@production_track"); */


Route::group(["prefix" => "manager", "namespace" => "Manager"], function() {
    Route::get("dashboard", "DashboardController@index");
    Route::get('auth/logout', "Auth\AuthController@logout");
    Route::get("password/edit", "Auth\PasswordController@getEditPassword");
    Route::post("password/edit", "Auth\PasswordController@postEditPassword");
    autoProcess();
    productions();
});

function productions() {
    Route::get("productions", "ProductionController@index");
    Route::get("productions/edit/{id}", "ProductionController@getEdit");
    Route::post("productions/edit/{id}", "ProductionController@postEdit");
    //AJAX
    Route::post("productions/ajax/post/edit/", "ProductionController@ajaxPostEdit");
    Route::post("productions/ajax/get/records", "ProductionController@ajaxGetRecords");
}

function autoProcess() {
    Route::get("auto/process", "AutoUpdateSearcherController@getProcess");
    Route::get("auto/process/add", "AutoUpdateSearcherController@getAddProcess");
    Route::post("auto/process/add", "AutoUpdateSearcherController@postAddProcess");
    Route::get("auto/process/delete/{id}", "AutoUpdateSearcherController@getDeleteProcess");
    //AJAX
    Route::post("auto/process/ajax/activated", "AutoUpdateSearcherController@ajaxAutoProcessActivated");
    //EN VIVO
    Route::get("auto/live/productions", "AutoUpdateSearcherController@getLiveProductions");
}
