<?php

namespace App\System\Library\Complements;

class UI {

    const MESSAGE_TYPE_INFO = "info";
    const MESSAGE_TYPE_SUCCESS = "success";
    const MESSAGE_TYPE_ERROR = "error";
    const MESSAGE_TYPE_WARNING = "warning";
    //VAR
    const SESSION_MODAL_MESSAGE_TITLE = "modal_message_title";
    const SESSION_MODAL_MESSAGE_CONTENT = "modal_message_content";

    /** Obtiene un array que activa un mensaje de usuar
     * io 
     * 
     * @param type $type Tipo de mensaje (info,success,error,warning)
     * @param type $message El mensaje a mostrar
     * @param type $params [null] Clases de estilo opcionales
     * @param type $pos [1] Posicion id del mensaje
     * @return type
     */
    public static function message($type, $message, $params = null, $pos = 1) {
        return array("message_type" => $type, "message_params" => $params, "message" => $message, "message_pos" => $pos);
    }

    public static function modalMessage($title, $message, $btn_close = "¡Entendido!") {
        return array(UI::SESSION_MODAL_MESSAGE_TITLE => $title, UI::SESSION_MODAL_MESSAGE_CONTENT => $message, "modal_message_btn_close" => $btn_close);
    }

}
