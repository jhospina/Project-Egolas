<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;

class QueuePersons extends Model {

    protected $table = 'queue_persons_autoupdate';
    public $timestamps = false;

    //Atributos del modelo en la base de datos
    const ATTR_ID = "id";
    const ATTR_PERSON_ID = "person_id";
    const ATTR_NAME = "name";
    const ATTR_LINK = "link";
    const ATTR_DATE_CREATION = "date_creation";
    const ATTR_DATE_PROCESSED = "date_processed";
    
    
    public static function searchByNameInQueue($name){
        $queues = QueuePersons::where(QueuePersons::ATTR_NAME, $name)->where(QueuePersons::ATTR_DATE_PROCESSED,null)->get();
        if (!count($queues) > 0)
            return null;
        foreach ($queues as $queue)
            return $queue;
    }
}
