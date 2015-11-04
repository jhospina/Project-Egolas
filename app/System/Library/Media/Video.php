<?php

namespace App\System\Library\Media;

use App\System\AutoUpdateSearcher\Providers\HTMLProvider;
use App\System\Models\Chapter;
use App\System\Library\Complements\Util;

class Video {

    //Token de lectura
    const TOKEN_READ = "c1xrJv7-ih1Fw5hX_b7JBvUyiIrooZejAfHZDC4CkXFiVuuq95-crA..";
    const PLAYER_DEFAULT="//players.brightcove.net/4584534319001/default_default/index.html";
    var $id_video;

    //METADATOS DEL VIDEO
    const FIELD_NAME = "name";
    const FIELD_LENGTH = "length";
    const FIELD_FLVURL = "FLVURL";

    function __construct($id_video) {
        $this->id_video = $id_video;
    }

    /** Obtiene un array con los datos solicitados del video
     * 
     * @param type $fields // Los datos a solicitar
     * @return type
     */
    function getData($fields) {
        if (!is_array($fields))
            return null;
        $json = new HTMLProvider();
        $json->loadContent("http://api.brightcove.com/services/library?command=find_video_by_id&video_id=" . $this->id_video . "&video_fields=" . Util::formatResultArray($fields, ",") . "&media_delivery=http&token=" . self::TOKEN_READ);
        $data = json_decode($json->htmlContent,true);
        if (count($fields) == 1)
            return array_values($data)[0];
        else
            return $data;
    }

}
