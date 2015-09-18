<?php

namespace App\System\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\System\Models\AutoProcess;
use Illuminate\Http\Request;
use \App\System\Library\Complements\UI;
use App\System\Models\QueueProductions;
use App\System\Library\Complements\DateUtil;
use App\System\AutoUpdateSearcher\Providers\ProductionProvider;

class AutoUpdateSearcherController extends Controller {

    function getProcess() {
        $processes = AutoProcess::all();
        return view("manager/contents/auto/process")->with("processes", $processes);
    }

    function getAddProcess() {
        return view("manager/contents/auto/add");
    }

    function postAddProcess(Request $request) {
        $data = $request->all();
        $process = new AutoProcess();
        if (strlen($data["name"]) < 5)
            return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_ERROR, "Error:", null, 2));
        if (strlen($data["description"]) < 5)
            return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_ERROR, "Error:", null, 2));
        $process->name = $data["name"];
        $process->description = $data["description"];
        $process->activated = 0;
        $process->save();

        return redirect("manager/auto/process")->with(UI::message(UI::MESSAGE_TYPE_SUCCESS, trans("sec.autoProcess.add.msj.success"), null, 2));
    }

    function getDeleteProcess($id_process) {
        $process = AutoProcess::find($id_process);
        if (is_null($process))
            return abort(403);
        $process->delete();

        return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_INFO, trans("sec.autoProcess.delete.msj.success"), null, 2));
    }

    function ajaxAutoProcessActivated(Request $request) {

        if (!$request->ajax())
            return;

        $data = $request->all();

        $process = AutoProcess::find(intval($data["id_process"]));
        $process->activated = intval($data["check"]);
        $process->save();

        return json_encode(array());
    }

    function getLiveProductions() {
        
        return view("manager/contents/auto/live/productions");
    }

}
