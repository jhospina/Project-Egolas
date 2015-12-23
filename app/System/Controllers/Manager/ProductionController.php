<?php

namespace App\System\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\System\Models\AutoProcess;
use Illuminate\Http\Request;
use \App\System\Library\Complements\UI;
use \App\System\Models\Production;
use Illuminate\Support\Facades\DB;
use App\System\Models\Taxonomy;
use App\System\Models\Chapter;
use App\System\Library\Complements\Util;
use App\System\Models\QueueProductions;
use App\System\AutoUpdateSearcher\Providers\ProductionProvider;
use App\System\Library\Complements\DateUtil;
use App\System\Library\Media\Video;
use App\System\Models\VideoCloudAccount;
use App\System\Library\Media\Image;

class ProductionController extends Controller {

    function index() {

        if (isset($_GET["search"])) {
            $productions = Production::where(Production::ATTR_TITLE, "LIKE", "%" . $_GET["search"] . "%")->orWhere(Production::ATTR_TITLE_ORIGINAL, "LIKE", "%" . $_GET["search"] . "%");
        } else {
            $productions = Production::where(Production::ATTR_TITLE, "!=", "%%");
        }

        if (isset($_GET["filter"]))
            $productions = $productions->where(Production::ATTR_STATE, $_GET["filter"]);


        $productions = $productions->orderBy("id", "DESC")->paginate(60);

        return view("manager/contents/production/index")->with("productions", $productions);
    }

    function getCreate() {
        $categories = Taxonomy::getAllTerms(Production::TAXONOMY_ID);
        return view("manager/contents/production/create")
                        ->with("categories", $categories);
    }

    function postCreate(Request $request) {
        $data = $request->all();
        //SLUG
        $data[Production::ATTR_SLUG] = Util::createSlug($data[Production::ATTR_TITLE] . " " . $data[Production::ATTR_YEAR]);
        $data[Production::ATTR_STATE] = Production::STATE_IN_WAIT;
        $production = new Production;
        $production->fill($data);
        $production->save();
        //Asigna las Categorias
        foreach ($data as $index => $value) {
            if (strpos($index, "cat-") !== false)
                $production->terms()->attach($value);
        }
        /*
         * OBTIENES LAS IMAGENES DE LA PRODUCCION
         */
        $path_image = public_path("assets/db/images/") . md5($production->title_original . $production->year);
        copy($data[Production::ATTR_POSTER], $path_image . "-poster.jpg");
        $production->poster = Util::convertPathToUrl($path_image . "-poster.jpg");
        if (strlen($data[Production::ATTR_IMAGE]) > 9) {
            copy($data[Production::ATTR_IMAGE], $path_image . ".jpg");
            $production->image = Util::convertPathToUrl($path_image . ".jpg");
        } else {
            $title_md5 = md5($production->title_original . $production->year);
            $image = new Image($production->poster);
            $production->image = $image->createCopy(214, 334, $title_md5, public_path("assets/db/images/"), false);
        }
        $production->save();
        //Cola de procesamiento
        $queue = new QueueProductions;
        //Si existe
        if (QueueProductions::existsByLink($data["imdb"])) {
            $queue = QueueProductions::where(QueueProductions::ATTR_LINK, $data["imdb"])->get()[0];
        } else {
            $queue->name = $data[Production::ATTR_TITLE_ORIGINAL];
            $queue->link = $data["imdb"];
            $queue->date_creation = DateUtil::getCurrentTime();
        }
        $queue->production_id = $production->id;
        $queue->date_processed = DateUtil::getCurrentTime();
        $queue->save();
        return redirect("manager/productions/edit/" . $production->id);
    }

    function getEdit($id) {
        $production = Production::find($id);
        if (is_null($production))
            return;

        $production_cats = $production->terms;

        $cats_selected = array();
        foreach ($production_cats as $cat) {
            $cats_selected[] = $cat->id;
        }

        $categories = Taxonomy::getAllTerms(Production::TAXONOMY_ID);

        $dealers = $production->dealers;

        return view("manager/contents/production/edit")
                        ->with("production", $production)
                        ->with("cats_selected", $cats_selected)
                        ->with("categories", $categories)
                        ->with("dealers", $dealers);
    }

    function postEdit(Request $request) {
        $data = $request->all();
        $production = Production::findOrNew($data[Production::ATTR_ID]);
        $data[Production::ATTR_SLUG] = Util::createSlug($data[Production::ATTR_TITLE] . " " . $data[Production::ATTR_YEAR]);
        $production->fill($data);
        $production->save();

        $terms = $production->terms;
        //Categorias
        $cats = array();
        foreach ($data as $index => $value) {
            if (strpos($index, "cat-") !== false)
                $cats[] = $value;
        }

        $terms_id = array();
        foreach ($terms as $term) {
            $terms_id[] = $term->id;
        }

        //Obtiene los terminos a disociar
        $unset = array_diff($terms_id, $cats);
        //Obtiene los termino a asociar
        $set = array_diff($cats, $terms_id);


        foreach ($unset as $index => $value)
            $production->terms()->detach($value);

        foreach ($set as $index => $value)
            $production->terms()->attach($value);

        return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_WARNING, trans("msg.info.change.saved"), null, 2));
    }

    function getMigration() {
        $total = Chapter::all()->count();
        return view("manager/contents/production/migration")->with("total", $total);
    }

    function ajax_loadVideosMigration(Request $request) {
        if (!$request->ajax())
            return;

        $data = $request->all();
        $skip = $data["skip"];
        $return = array();

        $chapters = Chapter::skip($skip)->take(30)->orderBy("id", "DESC")->get();

        foreach ($chapters as $chapter) {
            $video = new Video($chapter->video);
            $return[] = array("id" => $chapter->id, "url" => $video->getUrlVideo());
        }

        return json_encode($return);
    }

    function ajax_setVideosId(Request $request) {
        if (!$request->ajax())
            return;

        $data = $request->all();
        $video = $data["video"];
        $id = $data["id"];

        $chapter = Chapter::find($id);
        $chapter->video = $video;
        $chapter->videocloud_id = VideoCloudAccount::getCurrentAccountId();
        $chapter->save();
        return json_encode($data);
    }

    /** Edita un atributo de una produccion mendiante ajax (manager/productions/ajax/post/edit/)
     * 
     * @param Request $request
     * @return boolean
     */
    function ajaxPostEdit(Request $request) {
        if (!$request->ajax())
            return;

        $data = $request->all();
        $id = $data["id"];
        $attr = $data["attr"];
        $value = $data["value"];
        //Si es un titulo genera su slug
        if ($attr == Production::ATTR_TITLE) {
            $production = Production::find($id);
            $data[Production::ATTR_SLUG] = Util::createSlug($value . " " . $production->year);
            $production->slug = $data[Production::ATTR_SLUG];
        }

        DB::table("productions")->where("id", $id)->update([$attr => $value]);

        return json_encode($data);
    }

    /** Obtiene un numero indicado de registros
     * 
     * @param Request $request
     * @return type
     */
    function ajaxGetRecords(Request $request) {
        if (!$request->ajax())
            return;
        $data = $request->all();

        $productions = Production::orderBy(Production::ATTR_ID, "DESC")->take(intval($data["count"]))->get();

        return json_encode($productions);
    }

    function ajaxChapterCreator(Request $request) {
        if (!$request->ajax())
            return;
        $data = $request->all();
        $chapter = (isset($data[Chapter::ATTR_ID])) ? Chapter::findOrNew($data[Chapter::ATTR_ID]) : new Chapter();
        $chapter->production_id = $data[Chapter::ATTR_PRODUCTION_ID];
        $chapter->name = $data[Chapter::ATTR_NAME];
        $chapter->video = str_replace(array("\n", "\t", "\r", " "), "", $data[Chapter::ATTR_VIDEO]);
        $chapter->videocloud_id = VideoCloudAccount::getCurrentAccountId();
        $chapter->quality = $data[Chapter::ATTR_QUALITY];
        $chapter->languages = $data[Chapter::ATTR_LANGUAGES];
        $chapter->subtitles = (isset($data[Chapter::ATTR_SUBTITLES])) ? $data[Chapter::ATTR_SUBTITLES] : null;
        $chapter->type = $data[Chapter::ATTR_TYPE];
        $chapter->state = $data[Chapter::ATTR_STATE];
        $chapter->save();
        return json_encode(
                array(
                    Chapter::ATTR_ID => $chapter->id,
                    Chapter::ATTR_NAME => $chapter->name,
                    Chapter::ATTR_VIDEO => htmlentities($chapter->video),
                    Chapter::ATTR_QUALITY => $chapter->quality,
                    Chapter::ATTR_LANGUAGES => Util::formatResultArray($data[Chapter::ATTR_LANGUAGES], ",", "\"", "\""),
                    Chapter::ATTR_SUBTITLES => Util::formatResultArray($chapter->subtitles, ",", "\"", "\""),
                    Chapter::ATTR_STATE => $chapter->state)
        );
    }

    function ajaxDeleteChapter(Request $request) {
        if (!$request->ajax())
            return;
        $data = $request->all();
        Chapter::findOrNew($data[Chapter::ATTR_ID])->delete();
        return json_encode(array());
    }

    /** Agrega una nueva produccion desde un link
     * 
     * @param Request $request
     * @return type
     */
    function ajaxAddFromIMDB(Request $request) {

        if (!$request->ajax())
            return;

        $data = $request->all();
        $name = $data["name"];
        $link = $data["link"];

        if (QueueProductions::existsByLink($link, true))
            return json_encode(array("msg" => "<span class='glyphicon glyphicon-remove-circle'></span> " . $name . " Ya fue agregado y procesado anteriormente"));


        $provider = new ProductionProvider($name, $link);
        $production_id = $provider->save();
        if (is_null($production_id)) {
             return json_encode(array("msg" => "<span class='glyphicon glyphicon-remove-circle'></span> " . $name . " El acceso a la información de la producción no fue posible intentalo de nuevo."));
        }

        //Verifica si ya existia en la cola de procesamiento, si es asi lo indica como procesado y si no, lo crea.
        if (QueueProductions::existsByLink($link)) {
            $queue = QueueProductions::where(QueueProductions::ATTR_LINK, $link)->get()[0];
            $queue->date_processed = DateUtil::getCurrentTime();
            $queue->production_id = $production_id;
            $queue->save();
            return json_encode(array("msg" => "<span class='glyphicon glyphicon-ok-circle'></span> " . $name . " Procesado con éxito"));
        } else {
            $queue = new QueueProductions;
            $queue->production_id = $production_id;
            $queue->name = $name;
            $queue->link = $link;
            $queue->date_creation = DateUtil::getCurrentTime();
            $queue->date_processed = DateUtil::getCurrentTime();
            $queue->save();
            return json_encode(array("msg" => "<span class='glyphicon glyphicon-ok-circle'></span> " . $name . " Agregado y procesado con éxito"));
        }
    }

}
