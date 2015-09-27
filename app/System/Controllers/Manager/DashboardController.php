<?php

namespace App\System\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\System\Library\Complements\GoogleTranslate;
use stdClass;

class DashboardController extends Controller {

    function index() {
        return view("manager/contents/dashboard");
    }

}
