<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use \App\System\Models\Production;
use Illuminate\Http\Request;
use App\System\Models\User;
use App\System\Library\Security\ReCaptcha;
use App\System\Library\Com\Email;
use Illuminate\Support\Facades\Auth;
use App\System\Library\Complements\UI;
use App\System\Models\Production\ProductionFavorite;
use App\System\Library\Complements\DateUtil;

class UserController extends Controller {

    /** Recibe un peticion para crear una cuenta de usuario
     * 
     * @param Request $request
     * @return string
     */
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
        //   $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdEcQ4TAAAAABgMkSCLV3iVH-sXXk5Xqb79dfNt&response=".$data["g-recaptcha-response"]."&remoteip=".$_SERVER['REMOTE_ADDR']);

        $reCaptcha = new ReCaptcha("6LdEcQ4TAAAAABgMkSCLV3iVH-sXXk5Xqb79dfNt");
        // si se detecta la respuesta como enviada
        if (!$data["g-recaptcha-response"])
            return redirect()->back()->with(User::ATTR_NAME, $data[User::ATTR_NAME])
                            ->with(User::ATTR_LASTNAME, $data[User::ATTR_LASTNAME])
                            ->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL])
                            ->with("error-captcha", trans("gen.error.captcha"));

        $response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $data["g-recaptcha-response"]);

        //Valida el captcha
        if ($response == null || !$response->success)
            return redirect()->back()->with(User::ATTR_NAME, $data[User::ATTR_NAME])
                            ->with(User::ATTR_LASTNAME, $data[User::ATTR_LASTNAME])
                            ->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL])
                            ->with("error-captcha", trans("gen.error.captcha"));

        //Verifica si el corre ingresado existe
        if (User::existEmail($data[User::ATTR_EMAIL]))
            return redirect()->back()->with(User::ATTR_NAME, $data[User::ATTR_NAME])
                            ->with(User::ATTR_LASTNAME, $data[User::ATTR_LASTNAME])
                            ->with(User::ATTR_EMAIL, $data[User::ATTR_EMAIL])
                            ->with("error", "El correo electrónico ingresado ya esta registrado");


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

        //Crea las carpetas de manejo de archivos del usuarios
        mkdir(public_path($user->getPathTemporal()));
        mkdir(public_path($user->getPathUploads()));


        $activationLink = url("user/confirm/email/" . $keyActivation);

        $description = "<p>Este correo electrónico ha sido asociado a una nueva cuenta en bandicot&#46;com, para poder usar esta cuenta es necesario activarla confirmando este correo electrónico.</p>" .
                "<p>Para confirmar este correo electrónico debes hacer clic en botón \"Activar cuenta\" que se muestra a continuación:<br/><br/>" .
                "<a style='display: block;padding: 10px;border: 1px black solid;width: 200px;text-align: center;color: white;background: red;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;font-style: normal;text-transform: uppercase;margin: auto;' href='" . $activationLink . "' target='_blank'>Activar cuenta</a></p>" .
                "<p><i><b>Atención:<b/> Si crees que se ha tratado de una equivocación, por favor ignora este mensaje.</i></p>";

        $email = new Email("Activación de cuenta", $data[User::ATTR_EMAIL], [Email::VAR_NAME => $user->name, Email::VAR_DESCRIPTION => $description]);
        $email->send();

        Auth::loginUsingId($user->id);
        return redirect("user/dashboard")->with(UI::modalMessage("¡Bienvenido a Bandicot.com!", view("ui/msg/contents/bienvenido-a-bandicot-com")->render()));
    }

    /** Recibe una peticion ajax para agregar a favoritos una produccion (ajax/user/favorites/add/production)
     * 
     * @param Request $request
     * @return type
     */
    function ajax_addProductionToFavorites(Request $request) {

        if (!$request->ajax())
            return;

        $data = $request->all();

        //Verifica si la produccion ya se encuentra en favoritos
        if (Production::inFavorites($data["production_id"]))
            return json_encode(array(false));

        Auth::user()->favorites()->attach($data["production_id"], array(User::ATTR_FAVORITES_PIVOT_DATE => DateUtil::getCurrentTime()));

        return json_encode(array(true));
    }

    /** Recibe una peticion ajax para eliminar de favoritos una produccion
     * 
     * @param Request $request
     */
    function ajax_deleteProductionToFavorites(Request $request) {
        if (!$request->ajax())
            return;

        $data = $request->all();

        Auth::user()->favorites()->detach($data["production_id"]);

        return json_encode(array(true));
    }

    /**
     *  Agrega una produccion al listado de seguimientos del usuario
     */
    function ajax_trackProduction(Request $request) {
        if (!$request->ajax())
            return;

        $data = $request->all();

        if (Auth::check() && Auth::user()->role==User::ROLE_SUSCRIPTOR_PREMIUM && !Production::isTracking($data["production_id"])) {
            Auth::user()->tracks()->attach($data["production_id"]);
            return json_encode(array("true"));
        }

        return json_encode(array("false"));
    }

}
