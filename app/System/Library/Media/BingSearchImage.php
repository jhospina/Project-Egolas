<?php

namespace App\System\Library\Media;

use App\System\AutoUpdateSearcher\Providers\HTMLProvider;

class BingSearchImage extends HTMLProvider {

    const URL_SEARCH = "http://www.bing.com/images/search?scope=images&q=@&qft=+filterui:imagesize-wallpaper&FORM=R5IR4";

    private $megapixels; //Indica la cantida de megapixeles a buscar
    private $term; // El termino a buscar
    private $min_width; // El ancho minimo de la imagen
    private $min_height; // La altura minima de la imagen
    private $lastResult; //Almacena el resultado de la busqueda

    function __construct($term, $min_width, $min_height) {
        $this->term = $term;
        $this->min_width = $min_width;
        $this->min_height = $min_height;
        $this->megapixels = floor(($min_width * $min_height) / 1000000);
    }

    /** Retorna un array con un listado de enlace de imagenes de la busqueda realizada
     * 
     * @return type
     */
    function getResult() {
        $url = str_replace("@", urlencode($this->getTerm()), self::URL_SEARCH);
        parent::loadContent($url);
        
        $images = array();
        if (!preg_match_all('/href=[\"\']http(.+?)[\"\']/i', $this->htmlContent, $match_links, PREG_SET_ORDER))
            return;

        for ($i = 0; $i<count($match_links); $i++) {
            $images[] = "http".$match_links[$i][1];
        }
        $this->lastResult = $images;
        return $images;
    }

    function getMegapixels() {
        return $this->megapixels;
    }

    function setMegapixels($megapixels) {
        $this->megapixels = $megapixels;
    }

    function getTerm() {
        return $this->term;
    }

    function getMin_width() {
        return $this->min_width;
    }

    function getMin_height() {
        return $this->min_height;
    }

    function setTerm($term) {
        $this->term = $term;
    }

    function setMin_width($min_width) {
        $this->min_width = $min_width;
    }

    function setMin_height($min_height) {
        $this->min_height = $min_height;
    }

}
