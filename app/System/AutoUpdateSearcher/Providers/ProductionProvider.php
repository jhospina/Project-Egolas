<?php

namespace App\System\AutoUpdateSearcher\Providers;

use App\System\Library\Complements\Util;
use App\System\Models\Production;
use App\System\Models\Person;
use App\System\Models\QueuePersons;
use App\System\Models\Term;
Use App\System\Library\Complements\DateUtil;
use App\System\Library\Media\BingSearchImage;

class ProductionProvider extends HTMLProvider {

    private $title;
    private $title_original;
    private $slug;
    private $description;
    private $year;
    private $rating_rel = null;
    private $duration = null;
    private $image;
    private $poster;
    private $categories = array();
    //********************
    private $director;
    private $actors = array();
    //********************
    var $url_provider;
    var $name_ref;

    function __construct($name, $url) {
        $this->url_provider = $url;
        $this->name_ref = $name;
        parent::loadContent($url);
        $this->loadAttributes();
    }

    /**
     * Carga los atributos de la produccion dado por el contenido proveido en la URL
     */
    private function loadAttributes() {



        //Obtiene la tabla de referencia de información de la produccion
        if (!preg_match_all('/<table[^>]*id=["\']title-overview-widget-layout*["\']\>(.*?)<\/table>/', $this->htmlContent, $match))
            return;

        $match_content = $match[0][0];

        //(TITULO)**********************************/
        //
        //Obtiene el encabezado para extraer la información mas importante
        if (!preg_match_all('/<h1 [^>]*class=["\']header*["\']\>(.*?)<\/h1>/i', $match_content, $match, PREG_SET_ORDER))
            return;

        //Obtiene la referencia al titulo de la produccion
        if (!preg_match_all('/<span[^>]*class=["\']itemprop*["\'] itemprop=["\']name*["\']\>(.*?)<\/span>/i', $match[0][0], $match_title, PREG_SET_ORDER))
            return;

        //Asigna el titulo de la produccion
        $this->title = strip_tags((isset($match_title[0][1])) ? $this->getLatinTitle($match_title[0][1]) : null);

        $title_ori = $match_title[0][1];
        //(AÑO)*************************************/
        //Obtiene el año de lanzamiento de la produccion
        if (!preg_match_all('/<span[^>]*class=["\']nobr*["\']\>(.*?)<\/span>/i', $match[0][0], $match_year, PREG_SET_ORDER))
            return;

        $this->year = str_replace(array("(", ")"), "", strip_tags((isset($match_year[0][1])) ? $match_year[0][1] : null));

        //(TITULO ORIGINAL)*************************/
        //Busca el titulo original de la produccion, si no lo encuentra asigna el titulo encontrado
        if (preg_match_all('/<span[^>]*class=["\']title-extra*["\'] itemprop=["\']name*["\']\>(.*?)<\/span>/i', $match[0][0], $match_title_original, PREG_SET_ORDER))
            $this->title_original = str_replace(array("\"", "(original title)", "  "), "", strip_tags((isset($match_title_original[0][1])) ? $match_title_original[0][1] : null));
        else
            $this->title_original = $title_ori;

        //(SLUG)*************************/
        $this->slug = Util::createSlug(trim($this->title));

        //(DESCRIPCION)*************************/
        if (!preg_match_all('/<p[^>]*itemprop=["\']description*["\']\>(.*?)<\/p>/i', $match_content, $match_description, PREG_SET_ORDER))
            return;

        $this->description = Util::traslateText(strip_tags((isset($match_description[0][1])) ? $match_description[0][1] : null));

        //SECCION INFOBAR PARA EXTRAER - DURACION - CATEGORIAS
        if (!preg_match_all('/<div[^>]*class=["\']infobar*["\']\>(.*?)<\/div>/i', $match_content, $match_infobar, PREG_SET_ORDER))
            return;

        //(DURACION)*************************/
        if (preg_match_all('/<time[^>]*itemprop=["\']duration*["\'](.*?)\>(.*?)<\/time>/i', $match_infobar[0][1], $match_duration, PREG_SET_ORDER))
            $this->duration = intval(preg_replace("/[^0-9-.]/", "", strip_tags($match_duration[0][2])));

        //(CATEGORIAS)*************************/
        if (!preg_match_all('/<a\s+.*?href=[\"\']\/genre\/(.+?)[\"\']?[^>]*>(.*?)<\/a>/i', $match_infobar[0][1], $match_categories, PREG_SET_ORDER))
            return;

        foreach ($match_categories as $category) {
            $cat = strip_tags($category[2]);
            $this->categories[] = Util::textDecodetoSimply($cat);
        }

        //RATING
        if (preg_match_all('/<div[^>]*class=["\']titlePageSprite star-box-giga-star*["\']\>(.*?)<\/div>/i', $match_content, $match_rating, PREG_SET_ORDER))
            $this->rating_rel = trim(strip_tags($match_rating[0][1]));

        //IMAGEN
        if (!preg_match_all('/<img\s+.*?src=[\"\']?([^\"\' >]*)[\"\']?[^>]*>(.*?)[\"\']>/i', $match_content, $match_image, PREG_SET_ORDER))
            return;

        try {
            if (Util::UrlExist(strip_tags($match_image[0][1]))) {
                $path_image = public_path("assets/db/images/") . md5($this->title_original);
                copy(strip_tags($match_image[0][1]), $path_image . ".jpg");
                $this->image = Util::convertPathToUrl($path_image . ".jpg");
            } else {
                $this->image = null;
            }
        } catch (Exception $e) {
            $this->image = null;
        }

        //POSTER
        $search = new BingSearchImage($this->title_original . " poster", 1700, 1200);
        $images = $search->getResult();

        //Verifica que la url este bien
        $i = -1;
        do {
            $i++;
            $url_poster = $images[$i];
        } while (!Util::UrlExist($url_poster));

        try {
            if (is_array(@getimagesize($url_poster))) {
                copy($url_poster, $path_image . "-poster.jpg");
                $this->poster = Util::convertPathToUrl($path_image . "-poster.jpg");
            } else {
                $this->poster = null;
            }
        } catch (Exception $e) {
            $this->poster = null;
        }
        //(PERSONAL DE LA PRODUCCION)*************************************
        if (!preg_match_all('/<div\s+.*?itemprop=[\"\']director[\"\']?[^>]*>(.*?)<\/div>/i', $match_content, $match_director_bar, PREG_SET_ORDER))
            return;

        //DIRECTOR
        if (!preg_match_all('/<a[^>]*href=["\']\/name\/.*["\']*itemprop=["\']url*["\']\>(.*?)<\/a>/i', $match_director_bar[0][1], $match_director, PREG_SET_ORDER))
            return;

        $this->director = array(trim(strip_tags($match_director[0][1])), $this->extractLinkPerson($match_director[0][0]));

        //Actores
        if (!preg_match_all('/<table[^>]*class=["\']cast_list*["\']\>(.*?)<\/table>/', $this->htmlContent, $match_cast))
            return;

        if (!preg_match_all('/(<a)?[^>]*href=["\']\/name\/(.*?)itemprop=["\']url*(.*?)<span[^>]*class=["\']itemprop*["\'] itemprop=["\']name*["\']\>(.*?)<\/span><\/a>/i', $match_cast[0][0], $match_actors, PREG_SET_ORDER))
            return;

        foreach ($match_actors as $actor) {
            $this->actors[] = array(trim(strip_tags($actor[0])), $this->extractLinkPerson($actor[0]));
        }
    }

    function save() {
        if (!$this->validate())
            return;

        $production = (is_null($object = Production::searchByTitle($this->getTitle()))) ? new Production : $object;
        $production->title = $this->getTitle();
        $production->title_original = $this->getTitle_original();
        $production->year = $this->getYear();
        $production->slug = $this->getSlug();
        $production->description = $this->getDescription();
        $production->state = (is_null($this->getRating_rel())) ? Production::STATE_COMING_SOON : Production::STATE_IN_WAIT;
        $production->rating_rel = $this->getRating_rel();
        $production->duration = $this->getDuration();
        $production->image = $this->getImage();
        $production->poster = $this->poster;
        $production->save();

        //CATEGORIAS DE LA PRODUCCION
        $categories = $this->categories;

        foreach ($categories as $category) {
            //Verifica si ya existe la categoria, si no existe la crea y la asigna a la produccion
            $cat = Term::searchByName($category);
            if (is_null($term = $cat)) {
                $term = new Term;
                $term->name = ucfirst(strtolower($category));
                $term->taxonomy_id = Production::TAXONOMY_ID;
                $term->slug = Util::createSlug($category);
                $term->save();
            }
            $production->terms()->attach($term->id);
        }


        //Relaciona un director con la producción a uno existente o lo crea sin o existe
        $director = $this->getDirector();
        $staff_director = (is_null($person = Person::searchByName($director[0]))) ? new Person() : $person;
        $staff_director->name = $director[0];
        $staff_director->slug = Util::createSlug($director[0]);
        $staff_director->save();
        $staff_director->productions()->attach($production->id, array(Person::ATTR_PIVOT_ROLE => Person::ROLE_DIRECTOR));


        //Determina si el nombre del director se encuentra en cola para actualización, si no lo esta, lo agrega. 
        if (is_null(QueuePersons::searchByNameInQueue($director[0]))) {
            $queue = new QueuePersons;
            $queue->person_id = $staff_director->id;
            $queue->name = $director[0];
            $queue->link = $director[1];
            $queue->date_creation = DateUtil::getCurrentTime();
            $queue->save();
        }


        //Relaciona los actores con la produccion a uno existente o lo crea sino existe
        $actors = $this->actors;
        foreach ($actors as $actor) {
            if (is_null($actor[0]) || !isset($actor[0]) || strlen($actor[0]) == 0)
                continue;
            $staff_actor = (is_null($person = Person::searchByName($actor[0]))) ? new Person() : $person;
            $staff_actor->name = $actor[0];
            $staff_actor->slug = Util::createSlug($actor[0]);
            $staff_actor->save();
            $staff_actor->productions()->attach($production->id, array(Person::ATTR_PIVOT_ROLE => Person::ROLE_ACTOR));


            //Determina si el nombre del actor/actriz se encuentra en cola para actualización, si no lo esta, lo agrega. 
            if (is_null(QueuePersons::searchByNameInQueue($actor[0]))) {
                $queue = new QueuePersons;
                $queue->person_id = $staff_actor->id;
                $queue->name = $actor[0];
                $queue->link = $actor[1];
                $queue->date_creation = DateUtil::getCurrentTime();
                $queue->save();
            }
        }
    }

    function extractLinkPerson($text) {
        $regex = '/(\/name\/.*?)\"/i';
        return (preg_match_all($regex, $text, $partes)) ? \App\System\AutoUpdateSearcher\Feeds\ProductionFeed::WEB_SITE_SOURCE . str_replace(array("\"", "'"), "", $partes[0][0]) : null;
    }

    private function getLatinTitle($title) {
        $url = "https://www.google.com.co/search?num=100&site=&source=hp&q=" . Util::convertTextToSearch($title) . "+wikipedia&oq=Straight+Outta+Compton+wi&gs_l=hp.3.0.35i39j0j0i22i30l8.7079.8305.0.9175.5.5.0.0.0.0.306.973.0j4j0j1.5.0....0...1c.1.64.hp..1.4.667.0.OJ2Ztj0KNyk";

        $contentHtml = new HTMLProvider();
        $contentHtml->loadContent($url);


        if (!preg_match_all('/<li[^>]*class=["\']g*["\']\>(.*?)<\/li>/i', $contentHtml->htmlContent, $match_result))
            return $title;


        $link = Util::extractURLFromText($match_result[0][0]);
        $link = strip_tags($link[1]);

        //Pagina de wikipedia de la produccion
        if (strpos($link, "es.wikipedia") === false) {
            $contentHtml->loadContent($link);

            if (!preg_match_all('/<li[^>]*class=["\']interlanguage-link interwiki-es*["\']\>(.*?)<\/li>/i', $contentHtml->htmlContent, $match_result))
                return $title;

            $regex = '/\/\/[^\" ]+/i';
            preg_match_all($regex, $match_result[1][0], $link_es);

            $link = $link_es[0][0];
        }

        $contentHtml->loadContent((strpos($link, "https") === false) ? "https:" . $link : $link);


        if (!preg_match_all('/<table\s+.*?class=[\"\']infobox plainlist plainlinks[\"\']?[^>]*>(.*?)<\/table>/i', $contentHtml->htmlContent, $match_result))
            return $title;


        if (!preg_match_all('/Título<\/th>(.*?)<\/td>/i', $match_result[0][0], $match_info, PREG_SET_ORDER))
            return $title;



        if (strpos($match_info[0][0], "España") !== false) {

            if (strpos($match_info[0][0], "<i>") !== false) {

                preg_match_all('/<i>(.*?)<\/i>/i', $match_info[0][0], $match_title, PREG_SET_ORDER);

                if (strpos($match_info[0][0], "Latinoamérica") !== false) {
                    if (strpos($match_info[0][0], "España") > strpos($match_info[0][0], "Latinoamérica"))
                        return (isset($match_title[0][0])) ? strip_tags($match_title[0][0]) : $title;
                    else
                        return (isset($match_title[1][0])) ? strip_tags($match_title[1][0]) : $title;
                }
                if (strpos($match_info[0][0], "Hispanoamérica") !== false) {
                    if (strpos($match_info[0][0], "España") > strpos($match_info[0][0], "Hispanoamérica"))
                        return (isset($match_title[0][0])) ? strip_tags($match_title[0][0]) : $title;
                    else
                        return (isset($match_title[1][0])) ? strip_tags($match_title[1][0]) : $title;
                }

                return (isset($match_title[0][0])) ? strip_tags($match_title[0][0]) : $title;
            } else {

                $hispanoamerica = 'Hispanoam' . utf8_decode("é") . 'rica';
                $latinoamerica = 'Latinoam' . utf8_decode("é") . 'rica';
                $espana = '(Espa' . utf8_decode("ñ") . 'a)';

                $search_title = str_replace('T' . utf8_decode("í") . 'tulo', "", strip_tags(utf8_decode($match_info[0][0])));


                if (strpos($search_title, $espana) < strpos($search_title, $hispanoamerica) || strpos($search_title, $espana) < strpos($search_title, $latinoamerica))
                    $match_title = preg_replace('/.+\(' . $espana . '\)/i', "", $search_title);
                else
                    $match_title = $search_title;



                if (strpos($match_title, $hispanoamerica) !== false)
                    $match_title = str_replace("(" . $hispanoamerica . ")", "", preg_replace('/\(' . $hispanoamerica . '\)(.+)?/i', "", $match_title));
                if (strpos($match_title, $latinoamerica) !== false)
                    $match_title = str_replace("(" . $latinoamerica . ")", "", preg_replace('/\(' . $latinoamerica . '\)(.+)?/i', "", $match_title));


                return utf8_encode($match_title);
            }
        } else {

            if (!preg_match_all('/<i>(.*?)<\/i>/i', $match_info[0][0], $match_title, PREG_SET_ORDER))
                return strip_tags(str_replace("Título</th>", "", $match_info[0][0]));

            return Util::traslateText(strip_tags($match_title[0][0]));
        }
    }

    private function validate() {
        return (!is_null($this->director) && !is_null($this->description) && !is_null($this->image));
    }

    //****************************************
    //GETTERS AND SETTERS
    //****************************************

    function getTitle() {
        return $this->title;
    }

    function getTitle_original() {
        return $this->title_original;
    }

    function getSlug() {
        return $this->slug;
    }

    function getDescription() {
        return $this->description;
    }

    function getYear() {
        return $this->year;
    }

    function getPublic_age() {
        return $this->public_age;
    }

    function getRating_rel() {
        return $this->rating_rel;
    }

    function getDuration() {
        return $this->duration;
    }

    function getImage() {
        return $this->image;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setTitle_original($title_original) {
        $this->title_original = $title_original;
    }

    function setSlug($slug) {
        $this->slug = $slug;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setYear($year) {
        $this->year = $year;
    }

    function setPublic_age($public_age) {
        $this->public_age = $public_age;
    }

    function setRating_rel($rating_rel) {
        $this->rating_rel = $rating_rel;
    }

    function setDuration($duration) {
        $this->duration = $duration;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function getCategories() {
        return $this->categories;
    }

    function getDirector() {
        return $this->director;
    }

    function getActors() {
        return $this->actors;
    }

    function setCategories($categories) {
        $this->categories = $categories;
    }

    function setDirector($director) {
        $this->director = $director;
    }

    function setActors($actors) {
        $this->actors = $actors;
    }

}
