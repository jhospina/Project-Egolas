<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use \App\System\Models\Production;
use Illuminate\Support\Facades\Auth;
use App\System\Models\Term;

class CategoryController extends Controller {

    function getProductions($slug) {
        $category = Term::where(Term::ATTR_SLUG, $slug)->get()[0];
        //Obtiene la cantidad total de producciones asociadas a la categoria
        $cant=Term::findOrNew($category->id)->productions()->count();
        return view("frontend/contents/production/category")->with("category", $category)->with("cant",$cant);
    }

}
