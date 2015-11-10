<?php

namespace App\System\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\System\Library\Complements\UI;
use App\System\Library\Complements\DateUtil;
use App\System\Library\Com\Email;

class ActivityController extends Controller {

    function getRatings() {
        $ratings = Auth::user()->ratings()->orderBy("date", "DESC")->paginate(60);

        return view("user/contents/activity/ratings")
                        ->with("ratings", $ratings);
    }

    function getComments() {
        $comments = Auth::user()->comments()->orderBy("created_at", "DESC")->paginate(60);

        return view("user/contents/activity/comments")
                        ->with("comments", $comments);
    }

}
