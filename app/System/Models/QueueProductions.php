<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class QueueProductions extends Model {

    protected $table = 'queue_productions_autoupdate';
    public $timestamps = false;

    //Atributos del modelo en la base de datos
    const ATTR_ID = "id";
    const ATTR_PRODUCTION_ID = "production_id";
    const ATTR_NAME = "name";
    const ATTR_LINK = "link";
    const ATTR_DATE_CREATION = "date_creation";
    const ATTR_DATE_PROCESSED = "date_processed";

    /** Indica si una produccion existe en la cola de procesamiento dado por su nombre
     * 
     * @param type $name El nombre de la produccion
     * @param type $processed (Opcional = False) Si la produccion ya fue procesada
     * @return type
     */
    static function existsByName($name, $processed = false) {
        if (!$processed)
            return (QueueProductions::all()->where(QueueProductions::ATTR_NAME, $name)->count() > 0);
        else
            return (DB::table('queue_productions_autoupdate')->where(QueueProductions::ATTR_NAME, $name)->whereNotNull(QueueProductions::ATTR_DATE_PROCESSED)->count() > 0);
    }

    /** Indica si una produccion existe en la cola de procesamiento dado por su link
     * 
     * @param type $name El nombre de la produccion
     * @param type $processed (Opcional = False) Si la produccion ya fue procesada
     * @return type
     */
    static function existsByLink($link, $processed = false) {
        if (!$processed)
            return (QueueProductions::all()->where(QueueProductions::ATTR_LINK, $link)->count() > 0);
        else
            return (DB::table('queue_productions_autoupdate')->where(QueueProductions::ATTR_LINK, $link)->whereNotNull(QueueProductions::ATTR_DATE_PROCESSED)->count() > 0);
    }

}
