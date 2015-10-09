<?php

namespace App\System\Library\Complements;

class Util {

    /** Elimina la plularidad de una palabra
     * 
     * @param String $word
     * @return String Retorna la palabra en singular, de lo contrario null
     */
    static function deletePluralityWord($word) {
        if (!is_string($word))
            return null;

        if ($word[strlen($word) - 2] == "e" && $word[strlen($word) - 1] == "s")
            return substr($word, 0, strlen($word) - 2);

        if ($word[strlen($word) - 1] == "s")
            return substr($word, 0, strlen($word) - 1);

        return $word;
    }

    /** Convierte una URL en una direccion Path del servidor
     * 
     * @param String $URL La url a convertir
     * @return String Retorna el Path en caso de exito, de lo contrario null
     */
    static function convertUrltoPath($URL) {

        //Verifica que seea una URL valida
        if (filter_var($URL, FILTER_VALIDATE_URL) === false)
            return null;


        $URL = str_replace("\\", "/", $URL);

        //HTTP NORMAL
        if (strpos($URL, "http") !== false)
            $URL = str_replace("http://", "", $URL);

        //HTTP SECURE
        if (strpos($URL, "https") !== false)
            $URL = str_replace("https://", "", $URL);

        $public = public_path("");
        $desc = explode("/", $public);
        $last = end($desc);
        $posRaiz = strpos($URL, $last);
        return $public . substr($URL, $posRaiz + strlen($last));
    }

    static function convertPathToUrl($path, $dominio = "bandicot.com") {
        $path = explode($dominio, $path);
        return Util::createUrl($dominio . $path[1]);
    }

    /** Recorta un texto hasta la longitud dada.
     * 
     * @param type $text El texto a recortar
     * @param type $lenght La longitud en caracteres
     * @return string El texto recortado
     */
    static function trimText($text, $lenght) {
        $text = strip_tags($text);
        $text_end = "";
        $words = explode(" ", $text);
        for ($i = 0; $i < count($words); $i++) {
            $text_end.=$words[$i] . " ";
            if (strlen($text_end) >= $lenght)
                return substr($text_end, 0, strlen($text_end) - 1) . "...";
        }

        return $text;
    }

    /** Da formato de salida a un listado de objetos dado por la propiedad a imprimir del objeto.
     *  
     * @param Object $objects Listado de objetos de una misma clase
     * @param String $propiety  El nombre del a propiedad del objeto a imprimir
     * @param String $separator [, ] Un String separador entre cada propiedad del objeto
     * @param String $prefix [null] Un String a colocar antecedido de la propiedad  del objeto 
     * @param String $suffix [null] Un String a colocar posteriormente al valor de la propiedad del objeto
     * @return string Retorna un string en formato indicado. 
     */
    static function formatResultObjects($objects, $propiety, $separator = ", ", $prefix = null, $suffix = null) {
        $contenido = ""; //Almacena el resultado end

        foreach ($objects as $objeto)
            $contenido.=$prefix . $objeto[$propiety] . $suffix . $separator;

        return substr($contenido, 0, strlen($contenido) - strlen($separator));
    }

    /** Da formato de salida a un array
     *  
     * @param Object $array Listado de objetos de una misma clase
     * @param String $separator [, ] Un String separador entre cada propiedad del objeto
     * @param String $prefix [null] Un String a colocar antecedido de la propiedad  del objeto 
     * @param String $suffix [null] Un String a colocar posteriormente al valor de la propiedad del objeto
     * @return string Retorna un string en formato indicado. 
     */
    static function formatResultArray($array, $separator = ", ", $prefix = null, $suffix = null) {
        $contenido = ""; //Almacena el resultado end
        if (count($array) == 0)
            return null;
        foreach ($array as $indice => $valor)
            $contenido.=$prefix . $valor . $suffix . $separator;
        return substr($contenido, 0, strlen($contenido) - strlen($separator));
    }

    /** Extraer la extension de un archivo
     * 
     * @param type $name
     * @return type
     */
    static function fileExtractExtension($name) {
        $desc = explode(".", $name);
        return end($desc);
    }

    /** Extrae el nombre de un archivo. (Puede ser una url)
     * 
     * @param String $name El nombre del archivo, con extension.
     * @return String El nombre de archivo
     */
    static function fileExtractName($name) {
        $name = explode("/", $name);
        end($name);
        $name = explode(".", pos($name));
        reset($name);
        return $name[0];
    }

    /** Indica si una url existe
     * 
     * @param String $url La Url a verificar
     * @return boolean
     */
    static function UrlExist($url) {
        $url = @parse_url($url);
        if (!$url)
            return false;

        $url = array_map('trim', $url);
        $url['port'] = (!isset($url['port'])) ? 80 : (int) $url['port'];

        $path = (isset($url['path'])) ? $url['path'] : '/';
        $path .= (isset($url['query'])) ? "?$url[query]" : '';

        if (isset($url['host']) && $url['host'] != gethostbyname($url['host'])) {

            $fp = fsockopen($url['host'], $url['port'], $errno, $errstr, 30);

            if (!$fp)
                return false; //socket not opened

            fputs($fp, "HEAD $path HTTP/1.1\r\nHost: $url[host]\r\n\r\n"); //socket opened
            $headers = fread($fp, 4096);
            fclose($fp);

            if (preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers)) {//matching header
                return true;
            } else
                return false;
        } // if parse url
        else
            return false;
    }

    /** Elimna la extesion de un nombre de archivo y devuelve el nombre del archivo
     * 
     * @param type $url
     * @return type
     */
    static function fileDeleteExtension($url) {
        $name = explode("/", $url);
        end($name);
        $name = explode(".", pos($name));
        reset($name);
        return (isset($name[1])) ? str_replace("." . $name[1], "", $url) : null;
    }

    /** Retorna la url actual
     * 
     * @return string La url
     */
    static function getCurrentUrl() {
        $url = Util::crearUrl($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        return $url;
    }

    /** Crea una url
     * 
     * @param type $url path
     * @return URL
     */
    static function createUrl($url) {
        if (!isset($_SERVER['HTTPS']))
            return "http://" . $url;
        return($_SERVER['HTTPS']) ? "https://" . $url : "http://" . $url;
    }

    /** Indica si la conexion de la url actual es segura
     * 
     * @return boolean
     */
    static function isSecureConnection() {
        if (isset($_SERVER['HTTPS']))
            return $_SERVER['HTTPS'];
        else
            return false;
    }

    /** Filtra una url obteniendo unicamente la url, sin datos enviados por Get. 
     * 
     * @param type $url
     */
    static function filtrateUrl($url) {
        if (strpos($url, "?") !== false) {
            $parts = explode("?", $url);
            return $parts[0];
        } else
            return $url;
    }

    /** Extrae el dominio de una url
     * 
     * @param type $url
     * @return type
     */
    static function getDomainFromUrl($url) {
        $url = explode('://', $url);
        $ext = $url[0];
        if (isset($url[1]))
            $url = explode('/', $url[1]);
        return $ext . "://" . $url[0];
    }

    /** Reemplaza todos los caracteres especiales por codigo html
     * 
     * @param type $text El texto a descodificar
     * @return type 
     */
    static function textDecodetoHTML($text) {
        $search = array("Á", "É", "Í", "Ó", "Ú", "á", "é", "í", "ó", "ú", "ñ", "Ñ", "\"");
        $replace = array("&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Ntilde;", "&ntilde;", "&quot;");
        return str_replace($search, $replace, $text);
    }

    /** Reemplaza todos los caracteres especiales por caracteres simples
     * 
     * @param type $text El texto a descodificar
     * @return type 
     */
    static function textDecodetoSimply($text) {
        $search = array("Á", "É", "Í", "Ó", "Ú", "á", "é", "í", "ó", "ú", "ñ", "Ñ", "\"", "'");
        $replace = array("A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "N", "n", "", "");
        return str_replace($search, $replace, $text);
    }

    /** Indica si un color esta en formato RGB
     * 
     * @param type $color
     * @return type
     */
    static function isColorRGB($color) {
        return preg_match('/rgb\([0-9]+,[0-9]+,[0-9]+\)$/', Util::eliminarEspacios($color));
    }

    /** Convierte un color RGB en formato Hexadecimal
     * 
     * @param type $rgb [array|r,g,b|rgb(#,#,#)]
     * @return type Color hexadecimal
     */
    static function rgb2hex($rgb) {
        $rgb = Util::eliminarEspacios($rgb);
        if (is_string($rgb)) {
            if (strpos($rgb, "rgb") !== false) {
                $rgb = str_replace("rgb(", "", str_replace(")", "", $rgb));
            }
            $rgb = explode(",", $rgb);
        }

        $hex = "#";
        $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

        return $hex; // returns the hex value including the number sign (#)
    }

    /** Elimina todos los espacios en blanco de un texto
     * 
     * @param type $text
     * @return type
     */
    static function deleteSpaces($text) {
        return (is_string($text)) ? str_replace(" ", "", $text) : $text;
    }

    /** Retorna un color màs oscuro que el ingresado
     * 
     * @param type $color
     * @param type $cant
     * @return string
     */
    static function darkenColor($color, $cant) {
//voy a extraer las tres partes del color
        $rojo = substr($color, 1, 2);
        $verd = substr($color, 3, 2);
        $azul = substr($color, 5, 2);

//voy a convertir a enteros los string, que tengo en hexadecimal
        $introjo = hexdec($rojo);
        $intverd = hexdec($verd);
        $intazul = hexdec($azul);



//ahora verifico que no quede como negativo y resto
        if ($introjo - $cant >= 0)
            $introjo = $introjo - $cant;
        if ($intverd - $cant >= 0)
            $intverd = $intverd - $cant;
        if ($intazul - $cant >= 0)
            $intazul = $intazul - $cant;

//voy a convertir a hexadecimal, lo que tengo en enteros
        $rojo = dechex($introjo);
        $verd = dechex($intverd);
        $azul = dechex($intazul);

//voy a validar que los string hexadecimales tengan dos caracteres
        if (strlen($rojo) < 2)
            $rojo = "0" . $rojo;
        if (strlen($verd) < 2)
            $verd = "0" . $verd;
        if (strlen($azul) < 2)
            $azul = "0" . $azul;

//voy a construir el color hexadecimal
        $oscuridad = "#" . $rojo . $verd . $azul;

//la función devuelve el valor del color hexadecimal resultante
        return $oscuridad;
    }

    static function uppercaseText($cadena) {
        $cadena = mb_strtoupper($cadena, 'utf-8');
        return ($cadena);
    }

    /** Convierte un valor entero en un valor booleano
     * 
     * @param type $int El valor entero a convertir
     * @return type Retorna un valor booleano
     */
    static function convertIntToBoolean($int) {
        return (intval($int) > 0);
    }

    /** Convierte un valor booleano en un entero binario
     * 
     * @param type $bool El valor booleano a convertir
     * @return type
     */
    static function convertBooleanToInt($bool) {
        if (is_bool($bool))
            return ($bool) ? 1 : 0;
        else
            return null;
    }

    /** Obtiene la direccion IP del usuario
     * 
     * @return type
     */
    static function getIP() {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }
    }

    /** Convierte un valor medido en Bytes en otra unidad de medida
     * 
     * @param type $valor La cantidad a convertir
     * @param type $unidad El tipo de unidad a la que se va a convertir (BITS,KB,MB,GB,TB)
     * @param type $decimales
     * @return type
     */
    static function conversionBytes($valor, $unidad, $decimales = 2) {
        $valor = intval($valor);
        $unidad = strtoupper($unidad);

        switch ($unidad) {
            case "BITS":
                return number_format($valor * 8, $decimales) . " Bits";
            case "KB":
                return number_format(($valor / 1024), $decimales) . " Kb";
            case "MB":
                return number_format(($valor / 1048576), $decimales) . " Mb";
            case "GB":
                return number_format(($valor / 1073741824), $decimales) . " Gb";
            case "TB":
                return number_format(($valor / 1099511627776), $decimales) . " Tb";
        }
    }

    /** Agrega una varible por GET a una URL
     * 
     * @param type $url La url
     * @param type $var La variable a agregar
     * @param type $val El valor de la variable
     */
    static function addVariableToUrl($url, $var, $val) {
        //Si encuentra la variable indicada en la url la elimina
        if (strpos($url, "$var") !== false)
            $url = (strpos($url, "?$var") !== false) ? preg_filter("/(&|\?)" . $var . "=[[:alnum:]]+&?/", "?", $url, 1) : preg_filter("/(&|\?)" . $var . "=[[:alnum:]]+&?/", "&", $url, 1);
        $url = (strpos($url, "?") !== false) ? $url . "&" . $var . "=" . $val : $url . "?" . $var . "=" . $val;
        $url = str_replace("&&", "&", $url);
        return $url;
    }

    /** Indica si es una URL valida
     * 
     * @param type $url
     * @return boolean
     */
    static function isUrl($url) {
        return (filter_var($url, FILTER_VALIDATE_URL));
    }

    /** Crear una cadena slug
     * 
     * @param type $text
     * @return type
     */
    static function createSlug($text) {
        return str_replace(array(" ", ".", ":"), array("-", "", ""), strtolower(Util::textDecodetoSimply($text)));
    }

    /** Traduce un texto con ayuda de Google Translate
     * 
     * @param String $text Texto
     * @param type $ori [en] Idioma origen
     * @param type $lang [es] Idioma al que se traduce
     */
    static function traslateText($text, $ori = "en", $lang = "es") {
        $key = "trnsl.1.1.20150926T181524Z.a85a3099d51c2652.398557c17cf81bfbf684b1cc8610aed23291a4bc";
        $url = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=" . $key . "&lang=" . $lang . "&text=" . urlencode($text);
        $html = new \App\System\AutoUpdateSearcher\Providers\HTMLProvider();
        $html->loadContent($url);
        $content = json_decode($html->htmlContent);

        if ($content = json_decode($html->htmlContent))
            return $content->text[0];
        else
            return $text;
    }

    static function extractURLFromText($text) {
        $regex = '/https?\:\/\/[^\" ]+/i';
        preg_match_all($regex, $text, $partes);
        return ($partes[0]);
    }

    static function convertTextToSearch($text) {
        $search = array(" ", ":", "'", "\"");
        $replace = array("+", "", "", "");
        return strtolower(str_replace($search, $replace, $text));
    }

    /** Aplica saltos de linea a un texto, indicado por una bandera y un contador
     * 
     * @param type $text EL texto
     * @param type $flag La bandera que indica en donde se debe aplicar el salto de linea
     * @param type $count El contador que indica cada cuanto se debe aplicar el salto de linea
     * @param type $jump El indicador de salto
     * @return string
     */
    static function applyJumpsIntoText($text, $flag = ".", $count = 4, $jump = "<br/><br/>") {
        $text = explode($flag, $text);
        $result = "";

        for ($i = 0; $i < count($text); $i++) {
            $result.=$text[$i] . ". ";
            if ($i > 0 && $i % $count == 0) {
                $result.=$jump;
            }
        }

        return $result;
    }

    /** Retorna una importacion html de un script(JS) correspondiente a un path en el sistema
     * 
     * @param type $path
     * @return type
     */
    static function getImportJScriptCurrent($path) {
        $filename = Util::fileDeleteExtension(basename($_SERVER['PHP_SELF']));
        $url = Util::convertPathToUrl(public_path()) . "/assets/scripts/" . $path . $filename . ".js";
        return (Util::UrlExist($url)) ? "<script src='" . $url . "'></script>" : null;
    }

}
