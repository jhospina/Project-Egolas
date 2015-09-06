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

Route::get('manager/auth/login', "Manager\AuthController@getLogin");
Route::post('manager/auth/login', "Manager\AuthController@postLogin");
Route::get('manager/auth/logout', "Manager\AuthController@logout");

/*
  Route::get("/searcher/auto/feed/productions","AutoUpdateSearcherController@productions_feed");
  Route::get("/searcher/auto/track/production/{take}","AutoUpdateSearcherController@production_track"); */


Route::group(["prexi" => "manager", "namespace" => "Manager"], function() {
    Route::get("manager/dashboard", "DashboardController@index");
});
