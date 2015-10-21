<?php

namespace App\System\Models;
use Illuminate\Database\Eloquent\Model;

class ProductionRating extends Model{

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
}
