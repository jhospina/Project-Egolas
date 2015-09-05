<?php

namespace App\System\AutoUpdateSearcher\Providers;

class HTMLProvider {

    var $htmlContent;

    /** Carga en la propiedad $content de la clase el contenido HTML de una URL
     * 
     * @param type $url La URL de donde se va cargar el contenido HTML
     */
    function loadContent($url) {
        $url_content = '';
        $url = $this->adaptUrl($url);
        try {
            $file = @fopen($url, 'r');
            if ($file) {
                while (!feof($file)) {
                    $url_content .= @fgets($file, 4096);
                }
                fclose($file);
            }
            $this->htmlContent = $this->adapt($url_content);
        } catch (Exception $e) {
            $this->htmlContent = null;
        }
    }

    private function adapt($content) {
        return preg_replace("[\n|\r|\n\r]", "", $content);
    }

    private function adaptUrl($url) {
        $search = array("Á", "É", "Í", "Ó", "Ú", "á", "é", "í", "ó", "ú", "Ñ", "ñ", "&#8211;");

        $replace = array("%C3%81", //Á
            "%C3%89", //É
            "%C3%8D", //Í
            "%C3%93", //Ó
            "%C3%9A", //Ú
            "%C3%A1", //á
            "%C3%A9", //é
            "%C3%AD", //í
            "%C3%B3", //ó
            "%C3%BA", //ú
            "%C3%91", //Ñ
            "%C3%B1", //ñ,
            "%E2%80%93"
        );

        return str_replace($search, $replace, utf8_encode($url));
    }

}
