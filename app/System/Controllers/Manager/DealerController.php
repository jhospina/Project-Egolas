<?php

namespace App\System\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\System\Models\AutoProcess;
use Illuminate\Http\Request;
use App\System\Models\Dealer;
use App\System\Library\Complements\Util;
use App\System\Library\Complements\UI;

class DealerController extends Controller {

    function getIndex() {
        $dealers = Dealer::paginate(10);

        $id_creator = Dealer::all()->count() + 1;
        return view("manager/contents/dealer/index")->with("dealers", $dealers)->with("id_creator", $id_creator);
    }

    function getCreator($id) {
        $dealer = Dealer::findOrNew($id);
        return view("manager/contents/dealer/creator")->with("id", $id)->with("dealer", $dealer);
    }

    function postCreator(Request $request) {
        $data = $request->all();

        $dealer = Dealer::findOrNew($data[Dealer::ATTR_ID]);
        $dealer->name = $data[Dealer::ATTR_NAME];
        $dealer->website = $data[Dealer::ATTR_WEBSITE];
        $dealer->type = $data[Dealer::ATTR_TYPE];
        $dealer->model = $data[Dealer::ATTR_MODEL];


        if ($request->hasFile(Dealer::ATTR_IMAGE)) {

            if (isset($dealer->image)) {
                unlink(Util::convertUrltoPath($dealer->image));
            }

            $image = $request->file(Dealer::ATTR_IMAGE);

            if (!$image->isValid())
                return redirect()->back();

            $path_image = public_path("assets/db/images/") . "icon-dealer-" . md5($data[Dealer::ATTR_NAME]) . ".png";
            $image->move(public_path("assets/db/images/"), "icon-dealer-" . md5($data[Dealer::ATTR_NAME]) . ".png");
            $dealer->image = Util::convertPathToUrl($path_image);
        }

        $message = (isset($dealer->id)) ? UI::message(UI::MESSAGE_TYPE_WARNING, trans("msg.dealers.edit.success"), null, 2) : UI::message(UI::MESSAGE_TYPE_SUCCESS, trans("msg.dealers.add.success"), null, 2);

        $dealer->save();

        return redirect("manager/dealers")->with($message);
    }

}
