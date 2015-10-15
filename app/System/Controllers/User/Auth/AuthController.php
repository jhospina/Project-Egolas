<?php

namespace App\System\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use \App\System\Models\User;
use Illuminate\Support\Facades\Auth;
use \App\System\Library\Complements\UI;
use App\System\Models\PasswordReset;
use App\System\Library\Com\Email;
use App\System\Library\Complements\Util;
use App\System\Library\Complements\DateUtil;

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
            return redirect()->back()->withInput()->with(UI::message(UI::MESSAGE_TYPE_ERROR, trans("msg.login.error")))->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL]);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect("");
    }

    public function getRecovery() {
        return view("user/contents/auth/recovery");
    }

    public function postRecovery(Request $request) {
        $data = $request->all();
        $email = $data[User::ATTR_EMAIL];

        if (!User::existEmail($email))
            return redirect()->back()->withInput()->with(UI::message(UI::MESSAGE_TYPE_ERROR, "El correo electrónico ingresado no existe"));

        $user = User::where(User::ATTR_EMAIL, $email)->get()[0];

        $token = str_random(10);
        $reset = new PasswordReset;
        $reset->user_id = $user->id;
        $reset->email = $user->email;
        $reset->token = $token;
        $reset->active = Util::convertBooleanToInt(true);
        $reset->created_at = DateUtil::getCurrentTime();
        $reset->save();
        $description = "<p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en Bandicot, para poder reiniciar tu contraseña debes ingresar este código de seguridad:</p>" .
                "<p>Código:</p>" .
                "<p style='font-weigth:bold;font-size:15pt;'>" . $token . "</p>" .
                "<p>Cópialo y pégalo en el formulario donde lo solicitastes. El código tiene una vigencia de 2 horas.</p> ";

        $email_send = new Email("Recuperación de contraseña", $user->email, [Email::VAR_NAME => $user->name, Email::VAR_DESCRIPTION => $description]);
        $email_send->send();

        return redirect("user/auth/recovery?request=send-mail&form=token")->with(User::ATTR_EMAIL, $email);
    }

    public function postResetPassword(Request $request) {
        $data = $request->all();
        if (!isset($data[PasswordReset::ATTR_TOKEN]) || !isset($data[User::ATTR_EMAIL]) || strlen($data[PasswordReset::ATTR_TOKEN]) == 0 || strlen($data[User::ATTR_EMAIL]) == 0)
            return redirect("user/auth/recovery?request=send-mail&form=token")->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL])->with(UI::message(UI::MESSAGE_TYPE_ERROR, "Error: Solicitud invalida"));

        $email = $data[PasswordReset::ATTR_EMAIL];
        $token = $data[PasswordReset::ATTR_TOKEN];

        if (is_null($pet = PasswordReset::where(PasswordReset::ATTR_EMAIL, $email)->where(PasswordReset::ATTR_TOKEN, $token)->where(PasswordReset::ATTR_ACTIVE,Util::convertBooleanToInt(true))->get()))
            return redirect("user/auth/recovery?request=send-mail&form=token")->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL])->with(UI::message(UI::MESSAGE_TYPE_ERROR, "Error: Solicitud invalida"));

        if (DateUtil::difSec($pet[0]->created_at, DateUtil::getCurrentTime()) > 60 * 60 * 2){
            $pet[0]->active=Util::convertBooleanToInt(false);
            $pet->save();
            return redirect("user/auth/recovery?request=send-mail&form=token")->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL])->with(UI::message(UI::MESSAGE_TYPE_ERROR, "Error: El código de seguridad ha expirado. <a href='" . url("user/auth/recovery") . "'>¿Realizar una nueva solicitud?</a>"));
        }
            
        return view("user/contents/auth/resetPassword")->with(PasswordReset::ATTR_EMAIL, $email)->with(PasswordReset::ATTR_TOKEN, $token);
    }

    public function postSetResetPassword(Request $request) {
        $data = $request->all();

        if (!isset($data[PasswordReset::ATTR_TOKEN]) || !isset($data[User::ATTR_EMAIL]) || strlen($data[PasswordReset::ATTR_TOKEN]) == 0 || strlen($data[User::ATTR_EMAIL]) == 0 || !isset($data["password"]))
            return redirect("user/auth/recovery?request=send-mail&form=token")->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL])->with(UI::message(UI::MESSAGE_TYPE_ERROR, "Error: Solicitud invalida"));

        $email = $data[PasswordReset::ATTR_EMAIL];
        $token = $data[PasswordReset::ATTR_TOKEN];

        if (is_null($pet = PasswordReset::where(PasswordReset::ATTR_EMAIL, $email)->where(PasswordReset::ATTR_TOKEN, $token)->where(PasswordReset::ATTR_ACTIVE,Util::convertBooleanToInt(true))->get()))
            return redirect("user/auth/recovery?request=send-mail&form=token")->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL])->with(UI::message(UI::MESSAGE_TYPE_ERROR, "Error: Solicitud invalida"));

        if (DateUtil::difSec($pet[0]->created_at, DateUtil::getCurrentTime()) > 60 * 60 * 2){
            $pet[0]->active=Util::convertBooleanToInt(false);
            $pet->save();
            return redirect("user/auth/recovery?request=send-mail&form=token")->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL])->with(UI::message(UI::MESSAGE_TYPE_ERROR, "Error: El código de seguridad ha expirado. <a href='" . url("user/auth/recovery") . "'>¿Realizar una nueva solicitud?</a>"));
        }

        $user = User::where(User::ATTR_EMAIL, $email)->get()[0];
        $user->password = bcrypt($data["password"]);
        $user->save();
        return redirect("user/auth/login")->withInput()->with(UI::message(UI::MESSAGE_TYPE_SUCCESS, "Tu nueva contraseña ha sido establecida, ya puedes iniciar sesión"))->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL]);
    }

}
