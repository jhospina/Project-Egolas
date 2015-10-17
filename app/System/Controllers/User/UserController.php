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
use App\System\Library\Complements\Util;
use App\System\Library\Complements\DateUtil;
use App\System\Library\Media\Image;

class UserController extends Controller {

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

}
