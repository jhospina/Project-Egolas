<?php

namespace App\System\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller {

    function getDashboard() {
        return view("user/contents/dashboard");
    }

    function getAccount() {
        $user = Auth::user();
        return view("user/contents/account")->with("user",$user);
    }

}
