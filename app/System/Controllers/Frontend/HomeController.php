<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use \App\System\Models\Production;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        if (Auth::check()) {
            return redirect("browser");
        }
        $productions = Production::all()->take(60);
        return view("frontend/index")
                        ->with("productions", $productions);
    }

    public function getBrowser() {
        $productions = Production::all()->where(Production::ATTR_STATE,  Production::STATE_ACTIVE);
        return view("frontend/contents/gen/browser")
                        ->with("productions", $productions);
    }

    public function getTerms(){
        return view("frontend/contents/doc/terms");
    }
    
    public function getPrivacyPolicy(){
        return view("frontend/contents/doc/privacy-policy");
    }
    
}
