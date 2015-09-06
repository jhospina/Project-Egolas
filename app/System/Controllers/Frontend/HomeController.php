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

        $productions = Production::where(Production::ATTR_STATE, Production::STATE_IN_WAIT)->get();

        return view("searcher/index")->with("productions",$productions);
    }
    

}
