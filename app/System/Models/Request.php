<?php

/**
 *  DESCRIPCION DE LA CLASE: Esta clase modelo, almacena y relaciona las solicitudes de producciones de los usuarios premium
 */
namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model {
    public $timestamps = false;
    
    const ATTR_PRODUCTION_ID="production_id";
    const ATTR_USER_ID="user_id";
    const ATTR_QUEUE_ID="queue_id";
}