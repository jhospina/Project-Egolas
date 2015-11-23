<?php

namespace App\System\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\System\Models\VideoCloudAccount;
use Illuminate\Http\Request;
use App\System\Library\Complements\DateUtil;
use App\System\Library\Complements\UI;

class VideoCloudController extends Controller {

    function getIndex() {
        $accounts = VideoCloudAccount::orderBy("id", "DESC")->paginate(20);
        return view("manager/contents/videocloud/index")->with("accounts", $accounts);
    }

    function postCreate(Request $request) {
        $data = $request->all();
        //Registra una nueva cuenta de videocloud
        $account = new VideoCloudAccount;
        $account->email = $data["email"];
        $account->token = $data["token"];
        $account->player = $data["player"];
        $date = new DateUtil(DateUtil::getCurrentTime());
        $account->date = $date->getCurrentTime();
        $account->end = $date->addMonths(1);
        $account->save();

        return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_SUCCESS, "Cuenta creada exitosamente"));
    }

}
