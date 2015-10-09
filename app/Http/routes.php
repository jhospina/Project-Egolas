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



Route::group(["prefix" => "f", "namespace" => "Frontend"], function() {
    productions_frontend();
    persons_frontend();
    user_fronted();
});

function productions_frontend() {
    $class = "ProductionController@";
    Route::get("production/{slug}", $class . "getInfo");
    Route::get("production/{slug}/play", $class . "getPlay");
    Route::get("production/{slug}/play/{id_chapter}/{name}", $class . "getPlayChapter");
}

function persons_frontend() {
    $class = "PersonController@";
    Route::get("person/{slug}", $class . "getInfo");
}

function user_fronted(){
    $class = "UserController@";
    Route::post("user/post/create/account",$class."postCreateAccount");
    
}

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
    $class = "ProductionController@";
    Route::get("productions", $class . "index");
    Route::get("productions/edit/{id}", $class . "getEdit");
    Route::post("productions/edit/{id}", $class . "postEdit");
    //AJAX
    Route::post("productions/ajax/post/edit/", $class . "ajaxPostEdit");
    Route::post("productions/ajax/get/records", $class . "ajaxGetRecords");
    Route::post("productions/ajax/chapter/creator", $class . "ajaxChapterCreator");
    Route::post("productions/ajax/chapter/delete",$class."ajaxDeleteChapter");
}

function autoProcess() {

    $class = "AutoUpdateSearcherController@";

    Route::get("auto/process", $class . "getProcess");
    Route::get("auto/process/add", $class . "getAddProcess");
    Route::post("auto/process/add", $class . "postAddProcess");
    Route::get("auto/process/delete/{id}", $class . "getDeleteProcess");
    //AJAX
    Route::post("auto/process/ajax/activated", $class . "ajaxAutoProcessActivated");
    //EN VIVO
    Route::get("auto/live/productions", $class . "getLiveProductions");
}
