<?php

namespace App\System\Library\Media;

use App\System\AutoUpdateSearcher\Providers\HTMLProvider;
use App\System\Models\Chapter;
use App\System\Models\VideoCloudAccount;

class Video {

    var $id_video;
    var $token;
    var $player;

    //METADATOS DEL VIDEO
    const FIELD_NAME = "name";
    const FIELD_LENGTH = "length";
    const FIELD_FLVURL = "FLVURL";

    function __construct($id_video) {
        $this->id_video = intval(trim($id_video));
        $videocloud = VideoCloudAccount::find(Chapter::where(Chapter::ATTR_VIDEO, $id_video)->get()[0]->videocloud_id);
        $this->token = $videocloud->token;
        $this->player = $videocloud->player;
    }

    /** Obtiene un array con los datos solicitados del video
     * 
     * @return type
     */
    function getUrlVideo() {
        $json = new HTMLProvider();
        $json->loadContent("https://api.brightcove.com/services/library?command=find_video_by_id&video_id=" . $this->id_video . "&video_fields=" . Video::FIELD_FLVURL . "&media_delivery=http&token=" . $this->token);
        $data = json_decode($json->htmlContent, true);
        return $this->convertToSecure($data[Video::FIELD_FLVURL]);
    }

    /**
     * Obtiene la url del reproduccion asignado a la cuenta con el video a reproducir
     */
    function getUrlVideoPlayer() {
        return $this->player . "?videoId=" . $this->id_video;
    }

    function convertToSecure($link) {
        return str_replace(array("http://", ".vo."), array("https://", ".hs."), $link);
    }

}
