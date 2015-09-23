<?php

namespace App\System\Library\Enum;
use ReflectionClass;

class Language {

    const ES_ES = "ES_ES";// Español - España
    const ES_LT = "ES_LT";// Español - Latinoamerica
    const EN_US = "EN_US";// Ingles - USA
    const PR_BR="PR_BR";//Portugues de brasil
    
    static function getAll(){
        $class = new ReflectionClass(__CLASS__);
        $languages = array();
        foreach ($class->getConstants() as $index => $value) {
                $languages[$value] = trans("attr.language.".$value);
        }
        return $languages;
 
    }

}
