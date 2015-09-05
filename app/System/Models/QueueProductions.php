<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;

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

}
