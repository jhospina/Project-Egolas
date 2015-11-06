<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;
use App\System\Library\Complements\Util;

class AutoProcess extends Model {

    protected $table = "autoprocess";
    public $timestamps = false;

    const ATTR_ID = "id";
    const ATTR_NAME = "name";
    const ATTR_DESCRIPTION = "description";
    const ATTR_ACTIVATED = "activated";
    //CRONS
    const CRON_PRODUCTION_TRACK = "productionTrack";
    const CRON_PRODUCTIONS_FEED = "productionsFeed";
    const CRON_PERSON_TRACK = "personTrack";
    const CRON_USER_PRODUCTION_TRACK_SEND_MAIL = "userProductionTrackSendMail";

    /** Busca un proceso por su nombre
     * 
     * @param type $name Nombre del proceso
     * @return type
     */
    static function searchByName($name) {
        $query = AutoProcess::where(AutoProcess::ATTR_NAME, $name)->get();
        if (!count($query) > 0)
            return null;
        foreach ($query as $process)
            return $process;
    }

    /** Indica si un proceso esta activo, dado por su nombre
     * 
     * @param type $name El nombre del proceso
     * @return boolean
     */
    static function isActived($name) {
        if (is_null($process = AutoProcess::searchByName($name)))
            return false;

        return Util::convertIntToBoolean($process->activated);
    }

}
