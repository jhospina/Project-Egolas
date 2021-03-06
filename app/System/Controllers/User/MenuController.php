<?php

namespace App\System\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\System\Library\Complements\UI;
use App\System\Library\Complements\DateUtil;
use App\System\Library\Com\Email;
use App\System\Models\User;
use App\Http\Requests\Request;

class MenuController extends Controller {

    function getDashboard() {
        $plays = Auth::user()->playbacks()->orderBy("pivot_date", "DESC")->groupBy("id")->take(20)->get();
        $comments = Auth::user()->comments()->orderBy("created_at", "DESC")->take(6)->get();
        $ratings = Auth::user()->ratings()->orderBy("date", "DESC")->take(6)->get();
        return view("user/contents/dashboard")
                        ->with("comments", $comments)
                        ->with("ratings", $ratings)
                        ->with("plays", $plays);
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

    function getRequests() {

        if (Auth::user()->role != User::ROLE_SUSCRIPTOR_PREMIUM)
            return redirect("user/dashboard");

        $requests = Auth::user()->requests()->orderBy("id", "DESC")->paginate(10);
        return view("user/contents/requests")->with("requests", $requests);
    }

}
