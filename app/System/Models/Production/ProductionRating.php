<?php

namespace App\System\Models\Production;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductionRating extends Model {

    protected $table = "production_ratings";
    public $timestamps = false;

    const ATTR_RATING = "rating";
    const ATTR_DATE = "date";
    const ATTR_USER_ID = "user_id";
    const ATTR_PRODUCTION_ID = "production_id";
    const RATING_1 = "rating_1";
    const RATING_2 = "rating_2";
    const RATING_3 = "rating_3";
    const RATING_4 = "rating_4";
    const RATING_5 = "rating_5";

    /** Indica si el usuario en sesio ha calificado la producción indicada por su ID
     * 
     * @param type $production_id // Id de la produccion
     * @return type
     */
    static function userIsRated($production_id) {
        return (count(ProductionRating::where(ProductionRating::ATTR_PRODUCTION_ID, $production_id)->where(ProductionRating::ATTR_USER_ID, Auth::user()->id)->get()) > 0);
    }

}
