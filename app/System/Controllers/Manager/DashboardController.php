<?php

namespace App\System\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\System\Library\Complements\GoogleTranslate;
use stdClass;
use App\System\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    function index() {
        if (Auth::user()->role == User::ROLE_SUSCRIPTOR)
            return redirect("user/dashboard");
        return view("manager/contents/dashboard");
    }

}
