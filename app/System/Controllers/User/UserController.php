<?php

namespace App\System\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\System\Models\User;
use Illuminate\Support\Facades\Auth;
use App\System\Library\Complements\UI;
use App\System\Library\Complements\Util;
use App\System\Library\Complements\DateUtil;
use App\System\Library\Media\Image;
use Illuminate\Support\Facades\Hash;
use App\System\Library\Com\Email;

class UserController extends Controller {

    /** Actualiza la información de un usuario
     *  
     * @param Request $request
     * @return type
     */
    function postSaveInfoAccount(Request $request) {
        $data = $request->all();
        $user = Auth::user();
        if (strlen($data[User::ATTR_BIRTH]) > 0)
            $user->birth = $data[User::ATTR_BIRTH];
        else
            $user->birth = null;
        if ($data[User::ATTR_COUNTRY] != "none")
            $user->country = $data[User::ATTR_COUNTRY];
        $user->city = (strlen($data[User::ATTR_CITY]) > 0) ? strip_tags($data[User::ATTR_CITY]) : null;
        $user->save();
        return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_SUCCESS, "Tus datos han sido actualizados"));
    }

    /** Recibe una peticion post para cambiar la contraseña del usuario
     * 
     * @param Request $request
     * @return type
     */
    function postSaveNewPass(Request $request) {
        $data = $request->all();
        $user = Auth::user();
        if (!Hash::check($data["current-pass"], $user->password))
            return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_ERROR, "La contraseña actual ingresa es incorrecta"));
        $user->password = bcrypt($data["current-pass"]);
        $user->save();

        return redirect()->back()->with(UI::message(UI::MESSAGE_TYPE_SUCCESS, "Tu contraseña ha sido cambiada con éxito"));
    }

    /** Recibe una peticion Ajax para actualiza la foto de perfil de un usuario
     * 
     * @param Request $request
     * @return type
     */
    function ajaxUpdateAvatar(Request $request) {
        if (!$request->ajax() || !Auth::check())
            return json_encode(array());

        $extensions = array("png", "jpg", "jpeg");

        $avatar = $request->file("upload-avatar");

        $extension = strtolower($avatar->getClientOriginalExtension());
        //Valida la extension del archivo
        if (!in_array($extension, $extensions))
            return json_encode(array("error" => "Extension de archivo no permitida"));

        //Valida el tamaño del archivo
        if ($avatar->getSize() > 2000000)
            return json_encode(array("error" => "Tamaño del archivo excesivo"));

        //Almacena la imagen subida por el usuario en la carpeta temporal
        $filename = DateUtil::getTimeStamp() . "." . $extension;
        $temp = Auth::user()->getPathTemporal();
        $avatar->move($temp, $filename);

        //Crear carpeta de usuario predeterminada
        $image = new Image(url($temp . $filename));
        $url_avatar = $image->createCopy(200, 200, DateUtil::getTimeStamp(), Auth::user()->getPathUploads(), false);

        //Elimina el archivo temporal
        unlink(Util::convertUrltoPath(url($temp . $filename)));

        //Registra el nuevo avatar en la base de datos
        $user = User::findOrNew(Auth::user()->id);

        //Si el usuario tiene definido un avatar, lo elimina
        if (!is_null($user->avatar))
            unlink(Util::convertUrltoPath($user->avatar));
        $user->avatar = $url_avatar;
        $user->save();

        return json_encode(array("url" => $url_avatar));
    }

    /** Activa la cuenta del usuario dirigida desde el link con el codigo enviado por correo al usuario
     * 
     * @param Request $request
     */
    function getActivateAccount($token) {

        if (Auth::user()->state == User::STATE_ACTIVED_ACCOUNT)
            return redirect("");


        if (!is_null(User::where(User::ATTR_EMAIL, Auth::user()->email)->where(User::ATTR_KEY_ACTIVATION, $token)->get())) {
            $user = User::findOrNew(Auth::user()->id);
            $user[User::ATTR_STATE] = User::STATE_ACTIVED_ACCOUNT;
            $user->save();
            return redirect("user/dashboard")->with(UI::modalMessage("¡Gracias por activar tu cuenta!", view("ui/msg/contents/gracias-por-activar-tu-cuenta")->render()));
        }

        return redirect("");
    }

    /** Envia un correo de usuario para activar su cuenta. (user/account/ajax/send/email/confirmation)
     *  
     */
    function ajaxSendConfirmation(Request $request) {
        if (!$request->ajax())
            return;
        $description = "<p>Este correo electrónico ha sido asociado a una nueva cuenta en bandicot&#46;com, para poder usar esta cuenta es necesario activarla confirmando este correo electrónico.</p>" .
                "<p>Para confirmar este correo electrónico debes hacer clic en botón \"Activar cuenta\" que se muestra a continuación:<br/><br/>" .
                "<a style='display: block;padding: 10px;border: 1px black solid;width: 200px;text-align: center;color: white;background: red;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;font-style: normal;text-transform: uppercase;margin: auto;' href='" . Auth::user()->keyActivation . "' target='_blank'>Activar cuenta</a></p>" .
                "<p><i><b>Atención:<b/> Si crees que se ha tratado de una equivocación, por favor ignora este mensaje.</i></p>";

        $email = new Email("Activación de cuenta", Auth::user()->email, [Email::VAR_NAME => Auth::user()->name, Email::VAR_DESCRIPTION => $description]);
        $email->send();
        return json_encode(array());
    }

    function ajax_getProductionsFromFavorites(Request $request) {
        if (!$request->ajax())
            return;
        $data = $request->all();

        $favorites = Auth::user()->favorites()->orderBy("id", "DESC")->skip($data["skip"])->take(21)->get();

        if ($data["skip"] == 0)
            $total_productions = Auth::user()->favorites()->count();

        $response = array();

        foreach ($favorites as $production) {
            $data_fav = array("slug" => $production->slug,
                "id" => $production->id,
                "title" => $production->title,
                "image" => $production->image,
                "description" => Util::trimText($production->description, 150));

            if ($data["skip"] == 0)
                $data_fav["total"] = $total_productions;

            $response[] = $data_fav;
        }

        if (count($favorites) == 0)
            $response[] = array("total" => 0);

        return json_encode($response);
    }

}
