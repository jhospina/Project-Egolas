<?php

namespace App\System\Controllers\Manager;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use \App\System\Models\User;

class DashboardController extends Controller {
    
    function index(){
        return view("manager/contents/dashboard");
    }
    
    
}
