<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use \App\System\Models\Production;
use Illuminate\Support\Facades\Auth;
use App\System\Models\Term;

class HomeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        if (Auth::check())
            return redirect("browser");

        $productions = Production::all()->take(60);
        return view("frontend/index")
                        ->with("productions", $productions);
    }

    public function getBrowser() {
        if (!Auth::check())
            return redirect("user/auth/login?redirect_to=" . url("browser"));

        $productions = Production::orderBy("id", "DESC")->take(30)->get();
        $categories = Term::all();
        return view("frontend/contents/gen/browser")
                        ->with("productions", $productions)
                        ->with("categories", $categories);
    }

    public function getTerms() {
        return view("frontend/contents/doc/terms");
    }

    public function getPrivacyPolicy() {
        return view("frontend/contents/doc/privacy-policy");
    }

}
