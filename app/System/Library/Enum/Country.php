<?php

namespace App\System\Library\Enum;

use ReflectionClass;

class Country {

    const MEX = "México";
    const COL = "Colombia";
    const ESP = "España";
    const ARG = "Argentina";
    const VEN = "Venezuela";
    const PER = "Perú";
    const CHI = "Chile";
    const GUA = "Guatemala";
    const ECU = "Ecuador";
    const CUB = "Cuba";
    const BOL = "Bolivia";
    const RDO = "República Dominicana";
    const HON = "Honduras";
    const ELS = "El Salvador";
    const PAR = "Paraguay";
    const NIC = "Nicaragua";
    const COS = "Costa rica";
    const PRI = "Puerto rico";
    const PAN = "Panamá";
    const URU = "Uruguay";
    const USA = "Estados Unidos";

    static function getAll() {
        $class = new ReflectionClass(__CLASS__);
        return $class->getConstants();
    }

    static function getNameByAcronym($id) {
        $paises = Country::getAll();
        return (!is_numeric($id) && strlen($id) > 0) ? $paises[$id] : "";
    }

}
