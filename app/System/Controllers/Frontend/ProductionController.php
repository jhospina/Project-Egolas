<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use \App\System\Models\Production;
use App\System\Models\Person;
use App\System\Models\Chapter;
use App\System\Library\Security\Hash;
use App\System\Library\Media\Video;
use Illuminate\Http\Request;
use App\System\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\System\Library\Complements\DateUtil;
use App\System\Models\User;
use App\System\Library\Complements\Util;

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
        $id_video = $production->chapters[0]->video;
        $video = new Video($id_video);
        $url_video = $video->getData(array(Video::FIELD_FLVURL));
        return view("ui/media/videoplayer")
                        ->with("production", $production)
                        ->with("url_video", $url_video);
    }

    function getPlayChapter($slug, $id_chapter, $name) {
        $production = Production::where(Production::ATTR_SLUG, $slug)->where(Production::ATTR_STATE, Production::STATE_ACTIVE)->get()[0];
        $video = $production->chapters()->where(Chapter::ATTR_ID, $id_chapter)->get();

        return view("frontend/contents/production/play-chapter")
                        ->with("production", $production)
                        ->with("video", html_entity_decode($video[0]->video));
    }

    function videoPlayer() {
        $id_video = Hash::decrypt(urldecode($_GET["s"]));
        $video = new Video($id_video);
        $url_video = $video->getData(array(Video::FIELD_FLVURL));
        exit($url_video);
        //return view("ui/media/videoplayer")->with("url_video", $url_video);
    }

    function ajax_postComment(Request $request) {

        if (!$request->ajax())
            return;

        $data = $request->all();
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->production_id = $data[Comment::ATTR_PRODUCTION_ID];
        $comment->content = Util::removeURLsFromText(strip_tags($data[Comment::ATTR_CONTENT]),"[Enlace bloqueado]");
        $comment->created_at = DateUtil::getCurrentTime();
        $comment->save();

        return json_encode(array("content"=>$comment->content));
    }

    function ajax_getComments(Request $request) {
        if (!$request->ajax())
            return;
        $data = $request->all();

        $comments = Comment::where(Comment::ATTR_PRODUCTION_ID, $data[Comment::ATTR_PRODUCTION_ID])->orderBy("id", "DESC")->skip($data["skip"])->take(10)->get();

        $response = array();

        if ($data["skip"] == 0)
            $total_comments = Comment::where(Comment::ATTR_PRODUCTION_ID, $data[Comment::ATTR_PRODUCTION_ID])->count();

        foreach ($comments as $comment) {
            $user = User::findOrNew($comment->user_id);
            $data_comment = array("content" => $comment->content,
                "date" => DateUtil::calculateDifference($comment->created_at),
                "name" => $user->name,
                "avatar" => (is_null($user->avatar)) ? url("assets/images/user_icon.png") : $user->avatar);
            
            if ($data["skip"] == 0)
                $data_comment["total"] = $total_comments;

            $response[] = $data_comment;
        }
        
        if(count($comments)==0)
             $response[]=array("total"=>0);



        return json_encode($response);
    }

}
