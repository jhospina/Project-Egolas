<?php

namespace App\System\Controllers\Manager\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use \App\System\Models\User;
use \App\System\Library\Complements\UI;
use Illuminate\Http\Request;


class PasswordController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset requests
      | and uses a simple trait to include this behavior. You're free to
      | explore this trait and override any methods you wish to tweak.
      |
     */

use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function getEditPassword() {
        return view("manager/contents/user/editPassword");
    }

    public function postEditPassword(Request $request) {
        $data = $request->all();

        if (strlen($data["pass-new"]) <= 5)
            return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_ERROR, trans("msg.editPass.error.pass.new.invalid"), null, 2));

        if ($data["pass-new"] != $data["pass-rep"])
            return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_ERROR, trans("msg.editPass.error.pass.new.not.match"), null, 2));

        if (User::editPassword($data["pass"], $data["pass-new"]))
            return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_SUCCESS, trans("msg.editPass.success"), null, 2));
        else
            return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_ERROR, trans("msg.editPass.error.pass.current"), null, 2));
    }

}
