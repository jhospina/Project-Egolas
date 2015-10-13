<?php

namespace App\System\Controllers\User\Auth;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use \App\System\Models\User;
use Illuminate\Support\Facades\Auth;
use \App\System\Library\Complements\UI;

class AuthController extends Controller {

    use AuthenticatesAndRegistersUsers,
        ThrottlesLogins;

    protected $redirectPath = '/user/dashboard';
    protected $loginPath = '/user/auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function getLogin() {
        return view("user/contents/auth/login");
    }

    public function postLogin(Request $request) {
        $data = $request->all();

        //Login aceptado
        if (Auth::attempt([User::AUTH_EMAIL => $data[User::AUTH_EMAIL], User::AUTH_PASSWORD => $data[User::AUTH_PASSWORD]], (isset($data[User::AUTH_REMEMBER])))) {
            return redirect("browser");
            //Login Incorrecto
        } else {
            return redirect()->back()->withInput()->with(UI::message(UI::MESSAGE_TYPE_ERROR, trans("msg.login.error")))->with(User::ATTR_EMAIL,$data[User::ATTR_EMAIL]);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect("");
    }

}
