<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use \App\System\Models\Production;
use Illuminate\Support\Facades\Auth;
use App\System\Models\Person;
use App\System\Models\Term;

class SearchController extends Controller {

    function getSearch($query) {
        $productions = Production::search($query);
        $persons = Person::search($query);
        foreach ($persons as $person) {
            $pros = $person->productions()->orderBy(Production::ATTR_STATE, "DESC")->get();
            foreach ($pros as $pr) {
                $productions[] = $pr;
            }
        }
      
        $productions=Production::sortByState($productions);

        return view("frontend/contents/gen/search")
                        ->with("productions", $productions)
                        ->with("persons", $persons)
                        ->with("query", $query);
    }
    
    

}
