<?php

namespace App\System\Models\Util;

use App\System\Models\User;
use ReflectionClass;

class UserUtil {

    /** Obtiene un array con todos los atributos del modelo User
     * 
     * @return type
     */
    static function getAttributes() {
        $class = new ReflectionClass("User");
        $return = array();
        foreach ($class->getConstants() as $index => $value)
            if (strpos($index, "ATTR_") !== false)
                $return[$index] = $value;
        return $return;
    }

    /** Obtiene el porcetaje de completación de los datos del usuario
     * 
     * @param User $user
     * @return type
     */
    static function getPercentageCompleteProfile(User $user) {
        $attrs = UserUtil::getAttributes();
        $count_complete = 0;
        foreach ($attrs as $attr => $value) {
            if (!is_null($user[$value]))
                $count_complete++;
        }
        return ceil(($count_complete / count($attrs)) * 100);
    }

}
