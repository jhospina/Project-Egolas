<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Report extends Model {

    public $timestamps = false;

    const ATTR_USER_ID = "user_id";
    const ATTR_TYPE = "type";
    const ATTR_DESCRIPTION = "description";
    const ATTR_IMAGE = "image";
    const ATTR_DATE = "date";
    const TYPE_GENERAL = "RG";
    const TYPE_SEARCHER = "RS";
    const TYPE_PLAYER = "RP";
    const TYPE_COMMENTS = "RC";
    const TYPE_RATINGS = "RR";
    const TYPE_PRODUCTIONS = "PR";
    const TYPE_STAFF = "ST";
    const TYPE_ACCOUNT = "RA";
    const TYPE_USER_INTERFACE = "RI";
    const TYPE_FAVORITES = "RF";
    const TYPE_PAY_SISTEM = "RY";
    const TYPE_OTHER = "RO";

    static function getTypes() {
        $class = new ReflectionClass(__CLASS__);
        $return = array();
        foreach ($class->getConstants() as $index => $value)
            if (strpos($index, "TYPE_") !== false)
                $return[$value] = trans("attr.report.type." . $value);
        return $return;
    }

}
