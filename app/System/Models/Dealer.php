<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Dealer extends Model {

    public $timestamps = false;

    const ATTR_ID = "id";
    const ATTR_NAME = "name";
    const ATTR_WEBSITE = "website";
    const ATTR_IMAGE = "image";
    const ATTR_TYPE = "type";
    const ATTR_MODEL = "model";
    //Tipo
    const TYPE_WATCH_ONLINE = "WO";
    const TYPE_DOWNLOAD = "DW";
    //Modelos
    const MODEL_FREE = "MF";
    const MODEL_PREMIUM = "MP";
    //PIVOT - Productions - Dealers
    const PIVOT_PRODUCTION_ATTR_DEALER_ID = "dealer_id";
    const PIVOT_PRODUCTION_ATTR_PRODUCTION_ID = "production_id";
    const PIVOT_PRODUCTION_ATTR_STATE = "state";
    const PIVOT_PRODUCTION_ATTR_URL = "url";
    const PIVOT_PRODUCTION_ATTR_CONTENT = "content";
    const PIVOT_PRODUCTION_ATTR_LANGUAGES = "languages";
    const PIVOT_PRODUCTION_ATTR_QUALITY="quality";
    const PIVOT_PRODUCTION_STATE_AVAILABLE="SA";
    const PIVOT_PRODUCTION_STATE_OFFLINE="SO";
    const PIVOT_PRODUCTION_QUALITY_HD="HD";
    const PIVOT_PRODUCTION_QUALITY_FULL_HD="FH";
    const PIVOT_PRODUCTION_QUALITY_DVD="DV";
     const PIVOT_PRODUCTION_QUALITY_CAM="CA";
    
    
    


    /** Obtiene un array con los tipos de proveedores
     * 
     * @return type
     */
    static function getTypes() {
        $class = new ReflectionClass(__CLASS__);
        $types = array();
        foreach ($class->getConstants() as $index => $value) {
            if (strpos($index, strtoupper(Dealer::ATTR_TYPE) . "_") !== false)
                $types[] = $value;
        }
        return $types;
    }
    
    /** Obtiene un array con los modelos de proveedores
     * 
     * @return type
     */
    static function getModels() {
        $class = new ReflectionClass(__CLASS__);
        $models = array();
        foreach ($class->getConstants() as $index => $value) {
            if (strpos($index, strtoupper(Dealer::ATTR_MODEL) . "_") !== false)
                $models[] = $value;
        }
        return $models;
    }
    
    static function getPivotProductionStates(){
        $class = new ReflectionClass(__CLASS__);
        $states = array();
        foreach ($class->getConstants() as $index => $value) {
            if (strpos($index, strtoupper("PIVOT_PRODUCTION_STATE_")) !== false)
                $states[] = $value;
        }
        return $states;
    }
    
    
    static function getPivotProductionQualities(){
        $class = new ReflectionClass(__CLASS__);
        $qualities = array();
        foreach ($class->getConstants() as $index => $value) {
            if (strpos($index, strtoupper("PIVOT_PRODUCTION_QUALITY_")) !== false)
                $qualities[$value] = trans("attr.pivot.production.dealer.".Dealer::PIVOT_PRODUCTION_ATTR_QUALITY.".".$value);
        }
        return $qualities;
    }

}
