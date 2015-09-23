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

        $productions_recently = Production::where(Production::ATTR_STATE, Production::STATE_ACTIVE)->get();

        return view("frontend/index")->with("productions_recently",$productions_recently);
    }
    

}
