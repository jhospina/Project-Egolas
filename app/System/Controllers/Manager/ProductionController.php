<?php

namespace App\System\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\System\Models\AutoProcess;
use Illuminate\Http\Request;
use \App\System\Library\Complements\UI;
use \App\System\Models\Production;
use Illuminate\Support\Facades\DB;
use App\System\Models\Taxonomy;

class ProductionController extends Controller {

    function index() {
        $productions = DB::table("productions")->orderBy("id", "DESC")->paginate(60);
        return view("manager/contents/production/index")->with("productions", $productions);
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

        return view("manager/contents/production/edit")
                        ->with("production", $production)
                        ->with("cats_selected", $cats_selected)
                        ->with("categories", $categories)
        ;
    }

    function postEdit(Request $request) {
        $data = $request->all();
        $production = Production::findOrNew($data[Production::ATTR_ID]);
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

        for ($i = 0; $i < count($unset); $i++)
            $production->terms()->detach($unset[$i]);

        for ($i = 0; $i < count($set); $i++)
            $production->terms()->attach($set[$i]);

        return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_WARNING, trans("msg.info.change.saved"), null, 2));
    }

    /** Edita un atributo de una produccion mendiante ajax
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

}
