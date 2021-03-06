<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Chapter extends Model {

    public $timestamps = false;

    const ATTR_ID = "id";
    const ATTR_PRODUCTION_ID = "production_id";
    const ATTR_NAME = "name";
    const ATTR_VIDEO = "video";
    const ATTR_LANGUAGES = "languages";
    const ATTR_SUBTITLES = "subtitles";
    const ATTR_QUALITY = "quality";
    const ATTR_TYPE = "type";
    const ATTR_STATE = "state";
    const ATTR_VIDEOCLOUD_ID="videocloud_id";
    //TYPE
    const TYPE_MAIN = "MA";
    const TYPE_EPISODE = "EP";
    //STATE
    const STATE_AVAILABLE = "SA";
    const STATE_OFFLINE = "SO";
    //QUALITY
    const QUALITY_HD = "HD";
    const QUALITY_FULL_HD = "FH";
    const QUALITY_DVD = "DV";
    //SUBTITLES
    const SUBTITLE_ENGLISH = "EN";
    const SUBTITLE_SPANISH = "ES";
    const SUBTITLE_PORTUGUES = "PO";

    static function getTypes() {
        $class = new ReflectionClass(__CLASS__);
        $types = array();
        foreach ($class->getConstants() as $index => $value) {
            if (strpos($index, strtoupper(Chapter::ATTR_TYPE) . "_") !== false)
                $types[] = $value;
        }
        return $types;
    }

    static function getQualities() {
        $class = new ReflectionClass(__CLASS__);
        $qualities = array();
        foreach ($class->getConstants() as $index => $value) {
            if (strpos($index, strtoupper(Chapter::ATTR_QUALITY . "_")) !== false)
                $qualities[$value] = trans("attr.chapter." . Chapter::ATTR_QUALITY . "." . $value);
        }
        return $qualities;
    }

    static function getSubtitles() {
        $class = new ReflectionClass(__CLASS__);
        $subtitles = array();
        foreach ($class->getConstants() as $index => $value) {
            if (strpos($index, "SUBTITLE_") !== false)
                $subtitles[$value] = trans("attr.chapter." . Chapter::ATTR_SUBTITLES . "." . $value);
        }
        return $subtitles;
    }
    
    
    public function setLanguagesAttribute($value) {
        $this->attributes[Chapter::ATTR_LANGUAGES] = json_encode($value);
    }

    public function getLanguagesAttribute($value) {
        return json_decode($value);
    }

    public function setSubtitlesAttribute($value) {
        $this->attributes[Chapter::ATTR_SUBTITLES] = (is_null($value)) ? $value : json_encode($value);
    }

    public function getSubtitlesAttribute($value) {
        return (is_null($value)) ? $value : json_decode($value);
    }

    //MUTATORS
    public function setVideoAttribute($value) {
        if (isset($this->attributes[Chapter::ATTR_VIDEO]))
            if ($this->attributes[Chapter::ATTR_VIDEO] != $value)
            //Realizar un registro del antiguo slug
                Log\ChapterVideoID::add($this->attributes["id"],trim($this->attributes[Chapter::ATTR_VIDEO]));
        $this->attributes[Chapter::ATTR_VIDEO] = trim($value);
    }

}
