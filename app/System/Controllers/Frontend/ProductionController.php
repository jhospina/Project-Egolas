<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use \App\System\Models\Production;
use App\System\Models\Person;
use App\System\Models\Chapter;

class ProductionController extends Controller {

    function getInfo($slug) {
        $production = Production::where(Production::ATTR_SLUG, $slug)->get()[0];
        $categories = $production->terms;
        $director = $production->staff()->where(Person::ATTR_PIVOT_ROLE, Person::ROLE_DIRECTOR)->get()[0];
        $staff = $production->staff()->where(Person::ATTR_PIVOT_ROLE, Person::ROLE_ACTOR)->get();
        $isVideoMain = $production->haveVideoMain();
        $chapters = $production->chapters;
        return view("frontend/contents/production/info")
                        ->with("production", $production)
                        ->with("categories", $categories)
                        ->with("staff", $staff)
                        ->with("director", $director)
                        ->with("isVideoMain", $isVideoMain)
                        ->with("chapters", $chapters);
    }

    function getPlay($slug) {
        $production = Production::where(Production::ATTR_SLUG, $slug)->where(Production::ATTR_STATE, Production::STATE_ACTIVE)->get()[0];
        $video = $production->chapters[0]->video;
        return view("frontend/contents/production/play")
                        ->with("production", $production)
                        ->with("video", $video);
    }

    function getPlayChapter($slug, $id_chapter, $name) {
        $production = Production::where(Production::ATTR_SLUG, $slug)->where(Production::ATTR_STATE, Production::STATE_ACTIVE)->get()[0];
        $video = $production->chapters()->where(Chapter::ATTR_ID, $id_chapter)->get();

        return view("frontend/contents/production/play-chapter")
                        ->with("production", $production)
                        ->with("video", html_entity_decode($video[0]->video));
    }

}
