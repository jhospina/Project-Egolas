<?php

namespace App\System\Library\Complements;

use DateTime;

class DateUtil {

    const FORMAT_STANDARD = "Y-m-d H:i:s";

    var $format;
    var $year;
    var $month;
    var $day;
    var $hour;
    var $min;
    var $sec;
    var $object;

    /** EL constructor debe recibir una cadena de fecha en formato Y-m-d H:i:s
     * 
     * @param type $date
     */
    function __construct($date, $format = "Y-m-d H:i:s") {
        $this->format = $format;
        $this->assignAttributes($date);
    }

    function __toString() {
        return $this->object->format($this->format);
    }

    /** Cambia el formato de la fecha dado por un formato de fecha valido
     * 
     * @param type $newFormat
     */
    function changeFormat($newFormat) {
        $newDate = date($newFormat, strtotime($this->object->format($this->format)));
        $this->format = $newFormat;
        $this->assignAttributes($newDate);
    }

    /** Agrega un numero definido de meses a la fecha objeto y lo reasigna a la fecha
     * 
     * @param type $num El numero de meses a añadir
     * @return String Retorna la new fecha
     */
    function addMonths($num) {
        $this->object->add(date_interval_create_from_date_string("$num months"));
        $new_date = $this->object->format($this->format);
        $this->assignAttributes($this->object->format($this->format));
        return $new_date;
    }

    /** Agrega un numero definido de semanas a la fecha objeto y lo reasigna a la fecha
     * 
     * @param type $num El numero de semanas a añadir
     * @return String Retorna la new fecha
     */
    function addWeeks($num) {
        $this->object->add(date_interval_create_from_date_string("$num weeks"));
        $new_date = $this->object->format($this->format);
        $this->assignAttributes($this->object->format($this->format));
        return $new_date;
    }

    /** Agrega un numero definido de dias a la fecha objeto y lo reasigna a la fecha
     * 
     * @param type $num El numero de dias a añadir
     * @return String Retorna la new fecha
     */
    function addDays($num) {
        $this->object->add(date_interval_create_from_date_string("$num days"));
        $new_date = $this->object->format($this->format);
        $this->assignAttributes($this->object->format($this->format));
        return $new_date;
    }

    /** Agrega un numero definido de horas a la fecha objeto y lo reasigna a la fecha
     * 
     * @param type $num El numero de horas a añadir
     * @return String Retorna la new fecha
     */
    function addHours($num) {
        $this->object->add(date_interval_create_from_date_string("$num hours"));
        $new_date = $this->object->format($this->format);
        $this->assignAttributes($this->object->format($this->format));
        return $new_date;
    }

    /** Agrega un numero definido de minutos a la fecha objeto y lo reasigna a la fecha
     * 
     * @param type $num El numero de minutos a añadir
     * @return String Retorna la new fecha
     */
    function addMinutes($num) {
        $this->object->add(date_interval_create_from_date_string("$num minutes"));
        $new_date = $this->object->format($this->format);
        $this->assignAttributes($this->object->format($this->format));
        return $new_date;
    }

    /** Agrega un numero definido de segundos a la fecha objeto y lo reasigna a la fecha
     * 
     * @param type $num El numero de dias a añadir
     * @return String Retorna la new fecha
     */
    function addSeconds($num) {
        $this->object->add(date_interval_create_from_date_string("$num seconds"));
        $new_date = $this->object->format($this->format);
        $this->assignAttributes($this->object->format($this->format));
        return $new_date;
    }

    /** Sustraer un numero definido de dias a la fecha objeto
     * 
     * @param type $num
     * @return type
     */
    function subtractDays($num) {
        $this->object->sub(date_interval_create_from_date_string("$num days"));
        $new_date = $this->object->format($this->format);
        $this->assignAttributes($this->object->format($this->format));
        return $new_date;
    }

    /** Asigna los atributos de fecha al objeto de la clase
     * 
     * @param type $date Cadena de fecha en formato Y-m-d H:i:s
     */
    private function assignAttributes($date) {
        //"Y-m-d H:i:s" => "%d-%d-%d %d:%d:%d"
        $format = str_replace("d", "X", $this->format);
        $spe = str_replace(
                array("Y", "m", "X", "H", "i", "s", "j", "n"), "%d", $format);

        list($year, $month, $day, $hour, $min, $sec) = sscanf($date, $spe);

        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->hour = $hour;
        $this->min = $min;
        $this->sec = $sec;
        $this->object = new DateTime($date);
    }

    static function format($date) {
        $monthes = DateUtil::getMonthsNames();

        $ft = explode(" ", $date);

        $date = explode("-", $ft[0]);

        return trans("gen.date.format.01", array("dia" => $date[2], "mes" => $monthes[$date[1]], "ano" => $date[0], "hora" => $ft[1]));
    }

    static function calculateDifference($date1, $date2 = null) {
        $date2 = (is_null($date2)) ? DateUtil::getCurrentTime() : $date2;
        $minute = 60;
        $hour = $minute * 60;
        $day = $hour * 24;
        $month = $day * 30;
        $year = $month * 12;

        //formateamos las fechas a segundos tipo 1374998435
        $difference = DateUtil::difSec($date1, $date2);
        //comprobamos el tiempo que ha pasado en segundos entre las dos fechas
        //floor devuelve el número entero anterior
        if ($difference <= $minute) {
            $time = floor($difference) . " " . trans("gen.time.seconds");
        } elseif ($difference >= $minute && $difference < $minute * 2) {
            $time = "1 " . trans("gen.time.minute");
        } elseif ($difference >= $minute * 2 && $difference < $hour) {
            $time = floor($difference / $minute) . " " . trans("gen.time.minutes");
        } elseif ($difference >= $hour && $difference < $hour * 2) {
            $time = "1 " . trans("gen.time.hour");
        } elseif ($difference >= $hour * 2 && $difference < $day) {
            $time = floor($difference / $hour) . " " . trans("gen.time.hours");
        } elseif ($difference >= $day && $difference < $day * 2) {
            $time = "1 " . trans("gen.time.day");
        } elseif ($difference >= $day * 2 && $difference < $month) {
            $time = floor($difference / $day) . " " . trans("gen.time.days");
        } elseif ($difference >= $month && $difference < $month * 2) {
            $time = "1 " . trans("gen.time.month") . " " . DateDateUtil::calculateDifference($date1, date(DateDateUtil::FORMAT_STANDARD, intval($difference - $month) + strtotime($date1)));
        } elseif ($difference >= $month * 2 && $difference < $year) {
            $time = floor($difference / $month) . " " . trans("gen.time.months") . " " . DateDateUtil::calculateDifference($date1, date(DateDateUtil::FORMAT_STANDARD, intval($difference - $month * floor($difference / $month) + strtotime($date1))));
        } elseif ($difference >= $year && $difference < $year * 2) {
            $time = "1 " . trans("gen.time.year") . " " . DateDateUtil::calculateDifference($date1, date(DateDateUtil::FORMAT_STANDARD, intval($difference - $year) + strtotime($date1)));
        } elseif ($difference >= $year * 2) {
            $time = floor($difference / $year) . " " . trans("gen.time.years");
        }


        return (intval($time) <= 0 ) ? false : strtolower($time);
    }

    /** Obtiene la diferencia en segundo de dos fechas
     * 
     * @param type $date1
     * @param type $date2
     * @return type
     */
    static function difSec($date1, $date2) {
        return intval(strtotime($date2) - strtotime($date1));
    }

    static function numberAdapt($num) {
        return ($num < 10) ? "0" . $num : $num;
    }

    /** Obtiene el timeStamp del servidor indicado por año-mes-dia-hora-minutos-segundos
     * 
     * @return String
     */
    static function getTimeStamp($zone = 'America/Bogota') {
        date_default_timezone_set($zone);
        return date("YmdGis");
    }

    /** Obtiene la fecha actual de una zona horaria
     * 
     * @param type $format24 [True] Indica si la fecha es en horario de 24 horas
     * @param String $zone [America/Bogota] Zona Horaria
     * @return type
     */
    public static function getCurrentTime($format24 = true, $zone = 'America/Bogota') {
        date_default_timezone_set($zone);
        return ($format24) ? date('Y-m-d H:i:s') : date('Y-m-d h:i:sa');
    }

    /** Obtiene un array asociativo con los nombre de los mess del año
     * 
     */
    static function getMonthsNames() {
        return array("01" => trans("gen.date.january"),
            "02" => trans("gen.date.febrary"),
            "03" => trans("gen.date.march"),
            "04" => trans("gen.date.april"),
            "05" => trans("gen.date.may"),
            "06" => trans("gen.date.june"),
            "07" => trans("gen.date.july"),
            "08" => trans("gen.date.august"),
            "09" => trans("gen.date.september"),
            "10" => trans("gen.date.october"),
            "11" => trans("gen.date.november"),
            "12" => trans("gen.date.december"));
    }

    /** Obtiene el nombre de un mes dado por su numero
     * 
     * @param type $month
     * @return type
     */
    static function getNameMonth($month) {
        if ($month <= 0)
            return null;
        $monthes = DateUtil::getMonthsNames();
        return $monthes[$month];
    }

    function getFormat() {
        return $this->format;
    }

    function getYear() {
        return $this->year;
    }

    function getMonth() {
        return DateUtil::getNameMonth(DateUtil::numberAdapt($this->month));
    }

    function getDay() {
        return $this->day;
    }

    function getHour() {
        return $this->hour;
    }

    function getMin() {
        return $this->min;
    }

    function getSec() {
        return $this->sec;
    }

    function getObject() {
        return $this->object;
    }

    function setFormat($format) {
        $this->format = $format;
    }

    function setYear($year) {
        $this->year = $year;
    }

    function setMonth($month) {
        $this->month = $month;
    }

    function setDay($day) {
        $this->day = $day;
    }

    function setHour($hour) {
        $this->hour = $hour;
    }

    function setMin($min) {
        $this->min = $min;
    }

    function setSec($sec) {
        $this->sec = $sec;
    }

    function setObject($object) {
        $this->object = $object;
    }

}
