<?php

namespace App\System\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\System\Library\Complements\UI;
use App\System\Library\Complements\DateUtil;
use App\System\Library\Com\Email;

class MenuController extends Controller {

    function getDashboard() {
        return view("user/contents/dashboard");
    }

    function getAccount() {
        $user = Auth::user();
        return view("user/contents/account")->with("user", $user);
    }

    function getContributions() {
        $contributions = Auth::user()->contributions()->orderBy("id", "DESC")->get();
        return view("user/contents/contributions")->with("contributions", $contributions);
    }

    function getFavorites() {
         return view("user/contents/favorites");
    }

}
