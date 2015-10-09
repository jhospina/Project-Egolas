<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use \App\System\Models\Production;
use Illuminate\Http\Request;
use App\System\Models\User;
use App\System\Library\Security\ReCaptcha;
use App\System\Library\Com\Email;

class UserController extends Controller {

    function postCreateAccount(Request $request) {
        $data = $request->all();

        if (strlen($data[User::ATTR_NAME]) == 0 || strlen($data[User::ATTR_LASTNAME]) == 0 || !filter_var($data[User::ATTR_EMAIL], FILTER_VALIDATE_EMAIL) || strlen($data[User::ATTR_PASSWORD]) < 6)
            return redirect()->back()
                            ->with(User::ATTR_NAME, $data[User::ATTR_NAME])
                            ->with(User::ATTR_LASTNAME, $data[User::ATTR_LASTNAME])
                            ->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL])
                            ->with("error", trans("gen.info.error"));



        //*******************************************
        //CONTROL DE CAPTCHA
        //*******************************************

        $reCaptcha = new ReCaptcha("6LdEcQ4TAAAAABgMkSCLV3iVH-sXXk5Xqb79dfNt");
        // si se detecta la respuesta como enviada
        if (!$data["g-recaptcha-response"])
            return redirect()->back()->with(User::ATTR_NAME, $data[User::ATTR_NAME])
                            ->with(User::ATTR_LASTNAME, $data[User::ATTR_LASTNAME])
                            ->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL])
                            ->with("error-captcha", trans("gen.error.captcha"));

        $response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $data["g-recaptcha-response"]);

        //Valida el captcha
        /*
          if ($response == null || !$response->success)
          return redirect()->back()->with(User::ATTR_NAME, $data[User::ATTR_NAME])
          ->with(User::ATTR_LASTNAME, $data[User::ATTR_LASTNAME])
          ->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL])
          ->with("error-captcha", trans("gen.error.captcha")); */

        $keyActivation = \hash("sha256", $data[User::ATTR_EMAIL]);
        $user = new User;
        $user->name = ucfirst($data[User::ATTR_NAME]);
        $user->lastname = ucfirst($data[User::ATTR_LASTNAME]);
        $user->email = $data[User::ATTR_EMAIL];
        $user->password = bcrypt($data[User::ATTR_PASSWORD]);
        $user->state = User::STATE_UNCONFIRMED_ACCOUNT;
        $user->role = User::ROLE_SUSCRIPTOR;
        $user->keyActivation = $keyActivation;
        $user->save();

        $activationLink = url("user/confirm/email/" . $keyActivation);

        $description = "<p>Este correo electrónico ha sido asociado a una nueva cuenta en bandicot.com, para poder usar esta cuenta es necesario activarla confirmando este correo electrónico.</p>" .
                "<p>Para confirmar este correo electrónico debes hacer clic <a href='" . $activationLink . "'>aquí</a>. También puedes copiar y pegar el siguiente enlace:<br/><br/>" . $activationLink . "</p>" .
                "<p><i><b>Atención:<b/> Si crees que se ha tratado de una equivocación, por favor ignora este mensaje.</i></p>";

        $email = new Email("Activación de cuenta", $data[User::ATTR_EMAIL], [Email::VAR_NAME => $user->name, Email::VAR_DESCRIPTION => $description]);
        $email->send();

        return "REGISTRO REALIZADO";
    }

}
