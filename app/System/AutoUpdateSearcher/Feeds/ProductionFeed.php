<?php

namespace App\System\AutoUpdateSearcher\Feeds;

use \App\System\Models\QueueProductions;
use App\System\AutoUpdateSearcher\Providers\HTMLProvider;
use \App\System\Library\Complements\DateUtil;
use \App\System\Library\Complements\Util;

/** Clase: ProductionFeed
 *  Responsabilidad: Alimentar la cola de procesamiento de creaciòn o actualizacion de producciones
 */
class ProductionFeed extends HTMLProvider {

    const URL_SOURCE = "http://www.imdb.com/search/title?at=0&sort=moviemeter,asc&title_type=feature&start=";
    const WEB_SITE_SOURCE = "http://www.imdb.com";
    const MAX_NUM_QUERY = 100000; //La cantidad maxima a proveer

    public $dataRepository = array(); //Retiene la información cargada de cada producción
    var $skip = 0; //Cantidad de registros a omitir
    var $amount; //Cantidad de registros a obtener

    /** Instanciacion de la clase
     * 
     * @param type $amount [Defecto=50]Cantidad de registros a obtener
     */

    function __construct($amount = 50) {
        $this->amount = $amount;
        $this->loadAmountSkip();
    }

    /**
     * Carga el numero de registros a omitir, segun los datos obtenidos en la base de datos
     */
    private function loadAmountSkip() {
        $this->skip = QueueProductions::all()->where(QueueProductions::ATTR_DATE_PROCESSED, null)->count() + 1;
    }

    /**
     * Carga los datos de las producciones que se pondran en cola en la propiedad $dataRepository del objeto
     */
    public function loadRepository() {

        if ($this->skip >= self::MAX_NUM_QUERY)
            return;

        parent::loadContent(self::URL_SOURCE . $this->skip);

        //Selecciona y divide en secciones HTML el contenido relevante de cada produccion obtenida de la fuente
        preg_match_all('/<td[^>]*class=["\']title*["\']\>(.*?)<\/td>/i', $this->htmlContent, $sections, PREG_SET_ORDER);

        foreach ($sections as $section) {
            $data = $section[0];
            if (preg_match_all('/<a\s+.*?href=[\"\']?([^\"\' >]*)[\"\']?[^>]*>(.*?)<\/a>/i', $data, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    if (!Util::isUrl(self::WEB_SITE_SOURCE . $match[1]))
                        continue;
                    //Array(titulo, Enlace)
                    $this->dataRepository[] = array(strip_tags($match[0]), self::WEB_SITE_SOURCE . $match[1]);
                    break;
                }
            }
        }
    }

    /** Alimenta la cola de procesamiento de producciones
     * 
     * @return boolean
     */
    public function feedQueue() {

        //El repositorio de datos debe ser cargado
        if (!count($this->dataRepository) > 0)
            return false;

        foreach ($this->dataRepository as $data) {
            $queue = new QueueProductions;
            $queue->name = $data[0];
            $queue->link = $data[1];
            $queue->date_creation = DateUtil::getCurrentTime();
            $queue->save();
        }
    }

}
