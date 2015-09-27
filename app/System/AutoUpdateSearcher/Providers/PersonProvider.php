<?php

namespace App\System\AutoUpdateSearcher\Providers;

use App\System\AutoUpdateSearcher\Providers\HTMLProvider;
use App\System\Library\Complements\Util;
use App\System\Models\Person;

class PersonProvider extends HTMLProvider {

    private $name;
    private $slug;
    private $biography;
    private $image;
    //--------------
    public $url_provider;

    function __construct($name, $url) {
        $this->setName($name);
        $this->url_provider = $url;
        parent::loadContent($url);
        $this->loadAttributes();
    }

    private function loadAttributes() {
        //Obtiene la tabla de referencia de información de la produccion
        if (!preg_match_all('/<table[^>]*id=["\']name-overview-widget-layout*["\']\>(.*?)<\/table>/', $this->htmlContent, $match))
            return;
        $match_content = $match[0][0];

        //IMAGEN
        if (!preg_match_all('/<img\s+.*?src=[\"\']?([^\"\' >]*)[\"\']?[^>]*>(.*?)[\"\']>/i', $match_content, $match_image, PREG_SET_ORDER))
            return;

        $path_image = public_path("assets/db/images/") . md5($this->getName()) . ".jpg";

        try {
            copy(strip_tags($match_image[0][1]), $path_image);
        } catch (\Exception $e) {
            
        }

        $this->setImage(Util::convertPathToUrl($path_image));

        $this->loadContent(Util::filtrateUrl($this->url_provider) . "bio");

        //BIOGRAFIA
        if (!preg_match_all('/<div[^>]*class=["\']soda odd*["\']\>(.*?)<\/p>/i', $this->htmlContent, $match_bio, PREG_SET_ORDER))
            return;

        $bio = strip_tags(strip_tags($match_bio[0][0]));
        $this->setBiography(Util::traslateText($bio));
    }

    public function save() {
        $person = Person::where(Person::ATTR_NAME, $this->getName())->get()[0];
        $person->slug = Util::createSlug($person->name);
        $person->biography = $this->getBiography();
        $person->image = $this->getImage();
        $person->save();
    }

    function getName() {
        return $this->name;
    }

    function getSlug() {
        return $this->slug;
    }

    function getBiography() {
        return $this->biography;
    }

    function getImage() {
        return $this->image;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setSlug($slug) {
        $this->slug = $slug;
    }

    function setBiography($biography) {
        $this->biography = $biography;
    }

    function setImage($image) {
        $this->image = $image;
    }

}
