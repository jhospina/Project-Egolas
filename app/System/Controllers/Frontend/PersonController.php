<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use \App\System\Models\Production;
use App\System\Models\Person;
use \App\System\Models\Dealer;

class PersonController extends Controller {

    function getInfo($slug) {
        $person = Person::where(Person::ATTR_SLUG, $slug)->get()[0];
        $productions = $person->productions()->where(Production::ATTR_STATE, Production::STATE_ACTIVE)->get();
        return view("frontend/contents/person/info")
                        ->with("person", $person)
                        ->with("productions", $productions);
    }

}
