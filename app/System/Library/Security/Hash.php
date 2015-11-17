<?php

namespace App\System\Library\Security;

class Hash {

    const SALT = 'bandicot-peliculas-gratis';

    static function encrypt($string) {
        $result = '';
        $key = Hash::SALT;
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result.=$char;
        }
        return base64_encode($result);
    }

    static function decrypt($string) {
        $result = '';
        $key = Hash::SALT;
        $string = base64_decode($string);
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result.=$char;
        }
        return $result;
    }

    /** Ofusca un contenido HTML
     * 
     * @param type $html
     */
    static function dimToUnicode($html) {
        $ls = explode("|@|", chunk_split($html, 1, "|@|"));
        $res = "";
        for ($i = 0; $i < count($ls) - 1; $i++) {
            $res.="\u00" . bin2hex($ls[$i]);
        }
        return $res;
    }

    static function generateToken($length = 10, $uc = TRUE, $n = TRUE, $sc = FALSE) {
        $source = 'abcdefghijklmnopqrstuvwxyz';
        if ($uc == 1)
            $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($n == 1)
            $source .= '1234567890';
        if ($sc == 1)
            $source .= '|@#~$%()=^*+[]{}-_';
        if ($length > 0) {
            $rstr = "";
            $source = str_split($source, 1);
            for ($i = 1; $i <= $length; $i++) {
                mt_srand((double) microtime() * 1000000);
                $num = mt_rand(1, count($source));
                $rstr .= $source[$num - 1];
            }
        }
        return $rstr;
    }

}
