<?php

namespace App\System\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\System\Models\AutoProcess;
use Illuminate\Http\Request;
use \App\System\Library\Complements\UI;
use \App\System\Models\Production;
use Illuminate\Support\Facades\DB;
use App\System\Models\Taxonomy;
use \App\System\Models\Dealer;

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

        $dealers = $production->dealers;

        return view("manager/contents/production/edit")
                        ->with("production", $production)
                        ->with("cats_selected", $cats_selected)
                        ->with("categories", $categories)
                        ->with("dealers", $dealers);
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

    function getDealers($id) {
        $production = Production::find($id);
        $dealers = Dealer::all();
        return view("manager/contents/production/dealers")->with("production", $production)->with("dealers", $dealers);
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

    function ajaxPostDealer(Request $request) {

        if (!$request->ajax())
            return;

        $data = $request->all();

        $production = Production::findOrNew($data[Dealer::PIVOT_PRODUCTION_ATTR_PRODUCTION_ID]);

        $attrs = array(
            Dealer::PIVOT_PRODUCTION_ATTR_URL => $data[Dealer::PIVOT_PRODUCTION_ATTR_URL],
            Dealer::PIVOT_PRODUCTION_ATTR_CONTENT => (strlen($data[Dealer::PIVOT_PRODUCTION_ATTR_CONTENT]) > 0) ? $data[Dealer::PIVOT_PRODUCTION_ATTR_CONTENT] : null,
            Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES => (isset($data[Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES])) ? json_encode($data[Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES]) : null,
            Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES => (isset($data[Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES])) ? json_encode($data[Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES]) : null,
            Dealer::PIVOT_PRODUCTION_ATTR_QUALITY => $data[Dealer::PIVOT_PRODUCTION_ATTR_QUALITY]
        );



        $exist = DB::table('productions_dealers')
                        ->where(Dealer::PIVOT_PRODUCTION_ATTR_PRODUCTION_ID, $data[Dealer::PIVOT_PRODUCTION_ATTR_PRODUCTION_ID])
                        ->where(Dealer::PIVOT_PRODUCTION_ATTR_DEALER_ID, $data[Dealer::PIVOT_PRODUCTION_ATTR_DEALER_ID])
                        ->count() > 0;

        if (!$exist) {

            $attrs[Dealer::PIVOT_PRODUCTION_ATTR_STATE] = Dealer::PIVOT_PRODUCTION_STATE_OFFLINE;
            $production->dealers()->attach($data[Dealer::PIVOT_PRODUCTION_ATTR_DEALER_ID], $attrs);
        } else {
            DB::table("productions_dealers")
                    ->where(Dealer::PIVOT_PRODUCTION_ATTR_PRODUCTION_ID, $data[Dealer::PIVOT_PRODUCTION_ATTR_PRODUCTION_ID])
                    ->where(Dealer::PIVOT_PRODUCTION_ATTR_DEALER_ID, $data[Dealer::PIVOT_PRODUCTION_ATTR_DEALER_ID])
                    ->update($attrs);
        }

        return json_encode(array());
    }

    function ajaxPostEditPivotDealerState(Request $request) {

        if (!$request->ajax())
            return;

        $data = $request->all();

        DB::table("productions_dealers")
                ->where(Dealer::PIVOT_PRODUCTION_ATTR_PRODUCTION_ID, $data[Dealer::PIVOT_PRODUCTION_ATTR_PRODUCTION_ID])
                ->where(Dealer::PIVOT_PRODUCTION_ATTR_DEALER_ID, $data[Dealer::PIVOT_PRODUCTION_ATTR_DEALER_ID])
                ->update([Dealer::PIVOT_PRODUCTION_ATTR_STATE => $data[Dealer::PIVOT_PRODUCTION_ATTR_STATE]]);

        return json_encode(array());
    }

}