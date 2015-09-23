<?php

namespace App\System\Controllers\Manager\Auth;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use \App\System\Models\User;
use Illuminate\Support\Facades\Auth;
use \App\System\Library\Complements\UI;

class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

use AuthenticatesAndRegistersUsers,
    ThrottlesLogins;

    protected $redirectPath = '/manager/dashboard';
    protected $loginPath = '/manager/auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
        ]);
    }

    public function getLogin() {
        return view("manager/auth/login");
    }

    public function postLogin(Request $request) {
        $data = $request->all();

        //Login aceptado
        if (Auth::attempt([User::AUTH_EMAIL => $data[User::AUTH_EMAIL], User::AUTH_PASSWORD => $data[User::AUTH_PASSWORD]], (isset($data[User::AUTH_REMEMBER])))) {
            return redirect("manager/dashboard");
            //Login Incorrecto
        } else {
            return redirect()->back()->withInput()->with(UI::message(UI::MESSAGE_TYPE_WARNING, trans("msg.login.error")));
        }
    }

    public function logout() {
        Auth::logout();
        return redirect("manager/auth/login");
    }

}