<?php

namespace App\System\Controllers\User;

use App\Http\Controllers\Controller;
use \App\System\Models\Production;
use Illuminate\Http\Request;
use App\System\Models\User;
use App\System\Library\Security\ReCaptcha;
use App\System\Library\Com\Email;
use Illuminate\Support\Facades\Auth;
use App\System\Library\Complements\UI;

class UserController extends Controller {

    function postSaveInfoAccount(Request $request) {
        $data = $request->all();
        $user = Auth::user();
        if (strlen($data[User::ATTR_BIRTH]) > 0)
            $user->birth = $data[User::ATTR_BIRTH];
        else
            $user->birth=null;
        if ($data[User::ATTR_COUNTRY] != "none")
            $user->country = $data[User::ATTR_COUNTRY];
        $user->city = (strlen($data[User::ATTR_CITY])>0)?strip_tags($data[User::ATTR_CITY]):null;
        $user->save();
        return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_SUCCESS, "Tus datos han sido actualizados"));
    }

}
