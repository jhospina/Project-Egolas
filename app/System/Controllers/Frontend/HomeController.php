<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use \App\System\Models\Production;

class HomeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $productions= Production::all()->take(50);
        return view("frontend/index")
        ->with("productions",$productions);
    }
    

}
