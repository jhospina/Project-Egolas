<?php

use Illuminate\Support\Facades\Auth;

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


//*****************************************************
//PAYMENT*********************************************
//*****************************************************
Route::group(["prefix" => "premium", "namespace" => "Frontend", "middleware" => ["auth"]], function() {
    $class = "PaymentController@";
    Route::get("/", $class . "getIndex");
    Route::post("payment/post", $class . "postPayment");
    Route::get("payment/status", $class . "getStatus");
});



//*****************************************************
//AJAX*********************************************
//*****************************************************


Route::group(["prefix" => "ajax", "middleware" => ["auth"]], function() {
    ajax_comments();
    ajax_user();
});

function ajax_comments() {
    Route::post("comment/create", "Frontend\ProductionController@ajax_postComment");
    Route::post("comment/get", "Frontend\ProductionController@ajax_getComments");
    Route::post("production/rating/post", "Frontend\ProductionController@ajax_postRating");
}

function ajax_user() {
    Route::post("user/favorites/add/production", "Frontend\UserController@ajax_addProductionToFavorites");
    Route::post("user/favorites/delete/production", "Frontend\UserController@ajax_deleteProductionToFavorites");
    Route::post("user/favorites/get/productions", "User\UserController@ajax_getProductionsFromFavorites");
}

//*****************************************************
//USER*********************************************
//*****************************************************


Route::group(["prefix" => "user", "namespace" => "User", "middleware" => ["auth"]], function() {
    menu_user();
    auth_user();
    account_user();
});

function menu_user() {
    $class = "MenuController@";
    Route::get("dashboard", $class . "getDashboard");
    Route::get("account", $class . "getAccount");
    Route::get("contributions", $class . "getContributions");
    Route::get("favorites", $class . "getFavorites");
}

function auth_user() {
    $class = "Auth\AuthController@";
    Route::get("auth/logout", $class . "logout");
    Route::get("auth/recovery", $class . "getRecovery");
    Route::post("auth/recovery", $class . "postRecovery");
    Route::post("auth/recovery/reset/password", $class . "postResetPassword");
    Route::post("auth/recovery/reset/password/post", $class . "postSetResetPassword");
    Route::get("auth/login", $class . "getLogin");
    Route::post("auth/login", $class . "postLogin");
}

function account_user() {
    $class = "UserController@";
    Route::post("account/post/save/info", $class . "postSaveInfoAccount");
    Route::post("account/post/save/new/pass", $class . "postSaveNewPass");
    Route::get("confirm/email/{token}", $class . "getActivateAccount");
    //Ajax
    Route::post("account/ajax/upload/avatar", $class . "ajaxUpdateAvatar");
    Route::post("account/ajax/send/email/confirmation", $class . "ajaxSendConfirmation");
}

//*****************************************************
//FRONTEND*********************************************
//*****************************************************
Route::get('/', "Frontend\HomeController@index");


Route::group(["namespace" => "Frontend"], function() {
    productions_frontend();
    persons_frontend();
    user_fronted();
    home_fronted();
    doc_frontend();
});

function doc_frontend() {
    $class = "HomeController@";
    Route::get("doc/terms", $class . "getTerms");
    Route::get("doc/privacypolicy", $class . "getPrivacyPolicy");
}

function home_fronted() {
    $class = "HomeController@";
    Route::get("browser", $class . "getBrowser");
}

function productions_frontend() {
    $class = "ProductionController@";
    Route::get("production/{slug}", $class . "getInfo");
    Route::get("production/{slug}/play", $class . "getPlay");
    Route::get("production/{slug}/play/{id_chapter}/{name}", $class . "getPlayChapter");
    //Reproductor de video
    Route::get("media/videoplayer/play/", $class . "videoPlayer");
}

function persons_frontend() {
    $class = "PersonController@";
    Route::get("person/{slug}", $class . "getInfo");
}

function user_fronted() {
    $class = "UserController@";
    Route::post("user/post/create/account", $class . "postCreateAccount");
}

//*****************************************************
//MANAGER*********************************************
//*****************************************************

Route::group(["prefix" => "manager", "namespace" => "Manager", "middleware" => ["auth"]], function() {
    Route::get('auth/login', "Auth\AuthController@getLogin");
    Route::post('auth/login', "Auth\AuthController@postLogin");
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
    Route::post("productions/ajax/chapter/delete", $class . "ajaxDeleteChapter");
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
