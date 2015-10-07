<?php

namespace App\System\Library\Complements;

class UI {

    const MESSAGE_TYPE_INFO = "info";
    const MESSAGE_TYPE_SUCCESS = "success";
    const MESSAGE_TYPE_ERROR = "error";
    const MESSAGE_TYPE_WARNING = "warning";

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

}
