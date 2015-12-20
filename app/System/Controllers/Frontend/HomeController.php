<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use \App\System\Models\Production;
use Illuminate\Support\Facades\Auth;
use App\System\Models\Term;
use App\System\Library\Media\Image;
use App\System\Library\Complements\Util;
use DB;

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

        //Obtiene las 30 ultimas produccion agregadas
        $productions = DB::select("SELECT productions.id FROM chapters,productions WHERE chapters.production_id=productions.id and productions.state='" . Production::STATE_ACTIVE . "' GROUP BY chapters.production_id ORDER BY chapters.id DESC LIMIT 0,30 ");
        $categories = Term::orderBy(Term::ATTR_MOTE, "ASC")->get();
        return view("frontend/contents/gen/browser")
                        ->with("productions", $productions)
                        ->with("categories", $categories);
    }

    /**
     * Muestra el catalogo de peliculals de bandicot, solo para visitantes
     */
    public function getCatalogue() {
        if (Auth::check())
            return redirect("browser");
        return view("frontend/contents/gen/catalogue");
    }

    public function getTerms() {
        return view("frontend/contents/doc/terms");
    }

    public function getPrivacyPolicy() {
        return view("frontend/contents/doc/privacy-policy");
    }

    public function getHelp() {
        return view("frontend/contents/doc/help");
    }

    public function getCookiesPolicy() {
        return view("frontend/contents/doc/cookies-policy");
    }

}
