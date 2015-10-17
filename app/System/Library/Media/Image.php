<?php

/**
 * Name de la clase: Image
 * Descripcion: Esta clase controla y provee funcionalidad de una image
 *  Desarrollador por: John H. Ospina
 * Correo: jhonospina150@gmail.com
 */

namespace App\System\Library\Media;

use App\System\Library\Complements\Util;

class Image {

    public $name;
    public $extension;
    public $width;
    public $height;
    public $mime_type;
    public $route;
    public $path;
    public $objectImage;
    public $route_url;
    public $quality = 99;

    function __construct($url) {

        $this->name = Util::fileExtractName($url);
        $this->extension = strtolower(Util::fileExtractExtension($url));
        $this->path = Util::convertUrltoPath($url);
        $this->route = str_replace($this->name . "." . $this->extension, "", $this->path);
        $this->route_url = str_replace($this->name . "." . $this->extension, "", $url);
        /**
         * La function mime_content_type esta obsoleta
         */
        //$this->mime_type = mime_content_type($this->path);
        $this->mime_type = null;
        $dimensiones = getimagesize($this->path);
        $this->width = $dimensiones[0];
        $this->height = $dimensiones[1];
    }

    /** Crea una copy redimensionada y recortada adecuadamente sin defases de la image original y la almacena en el servidor con nuevo name
     * 
     * @param type $width Width de la copy
     * @param type $height Height de la copy
     * @param type $name Name de la copy
     * @param type $route La route donde se almacenara la copy
     * @param boolean $includeName Indica si debe adjuntar el antiguo nombre con el nuevo nombre 
     */
    public function createCopy($width, $height, $name, $route, $includeName = true) {

        $this->objectImage = $this->createImageFromOriginal();

        //Calcula los valores optimos a redimensioar sin desfasarse en los tamaños requeridos
        list($width_redim, $height_redim) = $this->calculateResizeMinProporcionate($width, $height);

        $copy_redim = imagecreatetruecolor($width_redim, $height_redim);

        $background = imagecolorallocate($copy_redim, 50, 255, 0);

        imagefilledrectangle($copy_redim, 0, 0, $width_redim, $height_redim, $background);
        imagecolortransparent($copy_redim, $background);

        //Redimensiona la image al proporcion adecuada
        imagecopyresized($copy_redim, $this->objectImage, 0, 0, 0, 0, $width_redim, $height_redim, $this->width, $this->height);

        //Almacenara la copy de la image redimensiona y recortada adecuadamente
        $copy_rec = imagecreatetruecolor($width, $height);

        $background = imagecolorallocate($copy_rec, 50, 255, 0);

        imagefilledrectangle($copy_rec, 0, 0, $width, $height, $background);
        imagecolortransparent($copy_rec, $background);

        list($x_recorte, $y_recorte) = $this->calculateCutPosition($width_redim, $height_redim, $width, $height);

        //Genera el recorte adecuado de la image
        imagecopy($copy_rec, $copy_redim, 0, 0, $x_recorte, $y_recorte, $width_redim, $height_redim);

        $destination = ($includeName) ? $route . $this->name . $name . "." . $this->extension : $route . $name . "." . $this->extension;

 
        $this->saveImage($copy_rec, $destination);
        return url($destination);
    }

    /** Calcula las dimensiones (width,height) minimas de redimension proporcional de la image original sin desfasarse para las dimensiones requeridas
     * 
     * @param Int $width El width requirido a redimensionar
     * @param Int $height La height requerida a redimensionar
     * @return array WidthxHeight
     */
    private function calculateResizeMinProporcionate($width, $height) {
        $height_min = ($this->height * $width) / $this->width;
        $width_min = ($this->width * $height) / $this->height;

        if ($height_min < $height)
            return array($width_min, $height);
        elseif ($height_min > $height)
            return array($width, $height_min);

        return array($width_min, $height_min);
    }

    /** Calcula la posicion de recorte adecuada para una image. Esta posición siempre tendera a ser centrada. 
     * 
     * @param Int $width Width de la image origen
     * @param Int $height Height de la image origen
     * @param Int $width_recorte Width del recorte
     * @param Int $height_recorte Height del recorte
     * @return Int Retorna un array con la posicions X,Y calculadas para el recorte adecuado.
     */
    private function calculateCutPosition($width, $height, $width_recorte, $height_recorte) {
        $x = 0;
        $y = 0;

        if ($width > $width_recorte && $height > $height_recorte) {
            $x = ($width - $width_recorte) / 2;
            $y = ($height - $height_recorte) / 2;
            return array($x, $y);
        }

        if ($width > $width_recorte) {
            $x = ($width - $width_recorte) / 2;
            return array($x, $y);
        }

        if ($height > $height_recorte) {
            $y = ($height - $height_recorte) / 2;
            return array($x, $y);
        }

        return array($x, $y);
    }

    /** Crea un objeto Image de la image original
     * 
     * @return Image
     */
    private function createImageFromOriginal() {
        switch ($this->extension) {
            case "jpg":
                $image = imagecreatefromjpeg($this->path);
                break;
            case "jpeg":
                $this->extension = "jpg";
                $image = imagecreatefromjpeg($this->path);
                break;
            case "png":
                $image = imagecreatefrompng($this->path);
                break;
            case "gif":
                $image = imagecreatefromgif($this->path);
                break;
        }
        return $image;
    }

    /** Crea una image en un archivo y lo almacena en el servidor
     * 
     * @param Image $image La image a guardar
     * @param type $destination El destino en donde se guardara la image
     * @param type $quality [90] La quality de la image con la que se guardara
     * @return type
     */
    private function saveImage($image, $destination) {
        switch ($this->extension) {
            case "jpg":
                return imagejpeg($image, $destination, $this->quality);
                break;
            case "jpeg":
                return imagejpeg($image, $destination, $this->quality);
                break;
            case "png":
                return imagepng($image, $destination, $this->quality/10);
                break;
            case "gif":
                return imagegif($image, $destination, $this->quality);
                break;
        }
    }

    public function __toString() {
        return "Name: " . $this->name . "<br/>" .
                "Extension: " . $this->extension . "<br/>" .
                "Mime Type: " . $this->mime_type . "<br/>" .
                "Route: " . $this->route . "<br/>" .
                "Route_URL" . $this->route_url . "<br/>";
        "Path: " . $this->path . "<br/>" .
                "Width: " . $this->width . " px<br/>" .
                "Height: " . $this->height . " px";
    }

    /** Indica si el archivo es una image, dado por su route
     * 
     * @param type $path
     * @return boolean
     */
    public static function pertain($path) {
        return (@is_array(getimagesize($path)));
    }

    //***************************************************
    //GETS Y SETS DE PROPIEDADES*************************
    //***************************************************
    function getName() {
        return $this->name;
    }

    function getExtension() {
        return $this->extension;
    }

    function getWidth() {
        return $this->width;
    }

    function getHeight() {
        return $this->height;
    }

    function getMime_type() {
        return $this->mime_type;
    }

    function getRoute() {
        return $this->route;
    }

    function getPath() {
        return $this->path;
    }

    function getRoute_url() {
        return $this->route_url;
    }

    function getObjectImage() {
        return $this->objectImage;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setExtension($extension) {
        $this->extension = $extension;
    }

    function setWidth($width) {
        $this->width = $width;
    }

    function setHeight($height) {
        $this->height = $height;
    }

    function setMime_type($mime_type) {
        $this->mime_type = $mime_type;
    }

    function setRoute($route) {
        $this->route = $route;
    }

    function setPath($path) {
        $this->path = $path;
    }

    function setObjectImage($objectImage) {
        $this->objectImage = $objectImage;
    }

    function setQuality($quality) {
        $this->quality = $quality;
    }

}
