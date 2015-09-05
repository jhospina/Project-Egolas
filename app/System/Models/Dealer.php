<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model {

    public $timestamps = false;

    const ATTR_ID = "id";
    const ATTR_NAME = "name";
    const ATTR_WEBSITE = "website";
    const ATTR_TYPE = "type";
    const ATTR_MODEL = "model";
    //Tipo
    const TYPE_WATCH_ONLINE="WO";
    const TYPE_DOWNLOAD="DO";
    const TYPE_PAY_TO_VIEW="PV";
    //Modelos
    const TYPE_FREE="TF";
    const TYPE_PREMIUM="TP";
   //PIVOT - Productions - Dealers
    const PIVOT_STATE="state";
    const PIVOT_URL="url";
    const PIVOT_CONTENT="content";
    const PIVOT_LANGUAJES="languages";
    
  }
