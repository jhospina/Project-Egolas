<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use \App\System\Models\Production;
use App\System\Models\Person;
use App\System\Models\Chapter;
use App\System\Library\Security\Hash;
use App\System\Library\Media\VideoCloudBrigthtcove;
use Illuminate\Http\Request;
use App\System\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\System\Library\Complements\DateUtil;
use App\System\Models\User;
use App\System\Library\Complements\Util;
use App\System\Models\Production\ProductionRating;
use App\System\Models\Production\ProductionFavorite;
use App\System\Models\Term;
use App\System\Models\Log\Slug;
use App\System\Library\Detection\MobileDetect;
use DB;

class ProductionController extends Controller {

    function getInfo($slug) {

        $production = Production::where(Production::ATTR_SLUG, $slug)->get();
        if (count($production) == 0) {
            //Verifica en el log el slug
            if (is_null($id = Slug::getIdProduction($slug)))
                return abort(404);
            else
                return redirect("production/" . Production::findOrNew($id)->slug);
        }

        $production = $production[0];

        //Visitantes
        if (!Auth::check()) {
            return view("frontend/contents/production/play-forbbiden")->with("production", $production)->with("message", view("ui/msg/contents/info-production-login")->with("production", $production)->render());
        }

        $categories = $production->terms;

        $director = ($production->staff()->count() > 0) ? $production->staff()->where(Person::ATTR_PIVOT_ROLE, Person::ROLE_DIRECTOR)->get()[0] : null;
        $staff = ($production->staff()->count() > 0) ? $production->staff()->where(Person::ATTR_PIVOT_ROLE, Person::ROLE_ACTOR)->get() : null;
        $isVideoMain = ($production->haveVideoMain() && $production->state == Production::STATE_ACTIVE);
        $chapters = $production->chapters;
        $rating_count = $production->ratings()->count();
        $rating = number_format(($production->ratings()->avg('rating') * 100) / 5, 0);
        $userIsRated = ProductionRating::userIsRated($production->id);
        $inFav = Production::inFavorites($production->id);
        return view("frontend/contents/production/info")
                        ->with("production", $production)
                        ->with("categories", $categories)
                        ->with("staff", $staff)
                        ->with("director", $director)
                        ->with("isVideoMain", $isVideoMain)
                        ->with("chapters", $chapters)
                        ->with("rating", $rating)
                        ->with("rating_count", $rating_count)
                        ->with("userIsRated", $userIsRated)
                        ->with("inFav", $inFav);
    }

    function getPlay($slug) {

        if (Auth::user()->state == User::STATE_UNCONFIRMED_ACCOUNT)
            return redirect("");

        $production = Production::where(Production::ATTR_SLUG, $slug)->get();
        if (count($production) == 0) {
            //Verifica en el log el slug
            if (is_null($id = Slug::getIdProduction($slug)))
                return abort(404);
            else
                return redirect("production/" . Production::findOrNew($id)->slug . "/play/0");
        }

        $production = $production[0];

        if ($production->state != Production::STATE_ACTIVE)
            return redirect("production/" . $slug);

        //Obtiene los datos de la ultima reproduccion del usuario
        list($play_date, $play_ip, $play_production) = Auth::user()->getLastPlayBack();

        //Verifica la restriccion de usuario gratis, en la que solo permite ver una pelicula por semana
        if (Auth::user()->role == User::ROLE_SUSCRIPTOR) {

            $time = DateUtil::difSec($play_date, DateUtil::getCurrentTime());
            /**
             * EL usuario gratis tiene 24 horas para ver la produccion que escogio
             */
            if ($time < (60 * 60 * 24) && $production->id != $play_production)
                return view("frontend/contents/production/play-forbbiden")->with("production", $production)->with("message", view("ui/msg/contents/play-forbidden-production-in-play")->with("production", Production::find($play_production))->render());

            //El usuario solo puede ver una produccion por semana
            if ($time < (60 * 60 * 24 * 7) && $time > (60 * 60 * 24))
                return view("frontend/contents/production/play-forbbiden")
                                ->with("production", $production)
                                ->with("message", view("ui/msg/contents/play-forbidden-production-time-out")
                                        ->with("production", Production::find($play_production))->with("time", $time)->render())
                                ->with("script", "assets/plugins/countdown/js/countdown.js")
                                ->with("css", array("assets/plugins/countdown/css/styles.css"));
        }

        $id_video = $production->chapters[0]->id;
        return view("ui/media/videoplayer")
                        ->with("production", $production)
                        ->with("id_video", $id_video);
    }

    /** Recibe una peticion ajax, para generar una url de video con una token especial
     * 
     * @param Request $request
     * @return type
     */
    function ajax_getVideoUrl(Request $request) {
        if (!$request->ajax())
            return;

        //Tiempo de paja
        sleep(3);
        $data = $request->all();
        //Verifica que el token no se repite
        do {
            $token = Hash::generateToken(100);
        } while (Auth::user()->playbacks()->where(User::ATTR_PLAYBACKS_PIVOT_TOKEN, $token)->count() > 0);


        //Genera un registro de reproduccion y token de validacion
        Auth::user()->playbacks()->attach($data["production_id"], array(User::ATTR_PLAYBACKS_PIVOT_IP => Util::getIP(),
            User::ATTR_PLAYBACKS_PIVOT_DATE => DateUtil::getCurrentTime(),
            User::ATTR_PLAYBACKS_PIVOT_TOKEN => $token));

        return json_encode(array("url" => url("get/source/video/" . $token . "/" . $data["id_video"]), "token" => $token));
    }

    /** Recibe una peticion con token de un unico uso que retornara la url de la fuente del video
     * 
     * @param type $token Token de la reproduccion generada anteriormente
     * @param type $id_video El id del video
     * @return type
     */
    function getVideoSource($token, $id_video) { 
        //Tiempo de paja
        // sleep(2);
        $playback = Auth::user()->playbacks()->where(User::ATTR_PLAYBACKS_PIVOT_TOKEN, $token)->get();

        //Verifica que el token de peticion exista
        if (count($playback) == 0)
            return abort(404);

        $playback = $playback[0];

        //Verifica que el token no haya sido validado
        if (intval($playback->pivot->validate) == true)
            return abort(404);

        //Valida el token de reproduccion
        Auth::user()->playbacks()->where(User::ATTR_PLAYBACKS_PIVOT_TOKEN, $token)->update(array(User::ATTR_PLAYBACKS_PIVOT_VALIDATE => true));

        $url_video = "http://videomega.tv/view.php?ref=" . DB::select("select " . Chapter::ATTR_VIDEOMEGA_REF . " from chapters where id='" . $id_video . "'")[0]->videomega_ref;
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $url_video");
        header("Connection: close");
    }

    function ajax_postComment(Request $request) {

        if (!$request->ajax())
            return;

        $data = $request->all();
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->production_id = $data[Comment::ATTR_PRODUCTION_ID];
        $comment->content = Util::removeURLsFromText(strip_tags($data[Comment::ATTR_CONTENT]), "[Enlace bloqueado]");
        $comment->created_at = DateUtil::getCurrentTime();
        $comment->save();

        return json_encode(array("content" => $comment->content));
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

        if (count($comments) == 0)
            $response[] = array("total" => 0);



        return json_encode($response);
    }

    /** Recibe la peticion con una calificacion de un usuario (ajax/production/rating/post)
     * 
     * @param Request $request
     */
    function ajax_postRating(Request $request) {

        if (!$request->ajax())
            return json_encode(array());

        $data = $request->all();

        if (ProductionRating::userIsRated($data["production_id"]))
            return json_encode(array());

        $rating = new ProductionRating();
        $rating->user_id = Auth::user()->id;
        $rating->production_id = $data["production_id"];
        $rating->rating = $data["rating"];
        $rating->date = DateUtil::getCurrentTime();
        $rating->save();

        return json_encode(array());
    }

    function ajax_getProductionsByCategory(Request $request) {

        if (!$request->ajax())
            return json_encode(array());


        $data = $request->all();
        $cat_id = $data["category_id"];
        $skip = $data["skip"];
        $filtered = (isset($data["filtered"]) && $data["filtered"] == "true") ? true : false;

        $productions = ($filtered) ? Term::findOrNew($cat_id)->productions()->where(Production::ATTR_STATE, Production::STATE_ACTIVE)->orderBy("state", "ASC")->skip($skip)->take(36)->get() : Term::findOrNew($cat_id)->productions()->orderBy("state", "ASC")->skip($skip)->take(36)->get();

        $response = array();
        if ($skip == 0)
            $total_productions = ($filtered) ? Term::findOrNew($cat_id)->productions()->where(Production::ATTR_STATE, Production::STATE_ACTIVE)->count() : Term::findOrNew($cat_id)->productions()->count();

        foreach ($productions as $production) {
            $data_production = array("html" => Production::getVisualHtml($production));

            if ($skip == 0)
                $data_production["total"] = $total_productions;
            $response[] = $data_production;
        }

        if (count($productions) == 0)
            $response[] = array("total" => 0);

        return json_encode($response);
    }

    function ajax_getProductions(Request $request) {
        if (!$request->ajax())
            return json_encode(array());

        $data = $request->all();
        $skip = $data["skip"];

        $productions = Production::orderBy("id", "ASC")->skip($skip)->take(72)->get();

        $response = array();
        if ($skip == 0)
            $total_productions = Production::all()->count();

        foreach ($productions as $production) {
            $data_production = array("html" => Production::getVisualHtml($production));

            if ($skip == 0)
                $data_production["total"] = $total_productions;
            $response[] = $data_production;
        }

        if (count($productions) == 0)
            $response[] = array("total" => 0);

        return json_encode($response);
    }

}
