<?php

namespace App\System\Controllers;

use App\Http\Controllers\Controller;
use App\System\AutoUpdateSearcher\Feeds\ProductionFeed;
use App\System\AutoUpdateSearcher\Providers\ProductionProvider;
use App\System\Models\QueueProductions;
use App\System\Library\Complements\DateUtil;
use App\System\AutoUpdateSearcher\Dealers\Cuevana;
use App\System\Models\Production;
use App\System\Models\Dealer;

class AutoUpdateSearcherController extends Controller {

    /**
     *  Alimenta la cola de procesamiento de producciones que seran añadidas o actualizadas
     */
    function productions_feed() {
        $productionFeed = new ProductionFeed();
        //Carga datos de producciones (peliculas) en el repositorio
        $productionFeed->loadRepository();
        //Alimenta la cola de actualizaciones de peliculas
        $productionFeed->feedQueue();
    }

    /**
     * Realiza el seguimiento a una producción para crearla o actualizarla
     */
    function production_track($take) {
        $queue = QueueProductions::where(QueueProductions::ATTR_DATE_PROCESSED, null)->orderBy(QueueProductions::ATTR_ID, "ASC")->take($take)->get();

        foreach ($queue as $production) {
            $provider = new ProductionProvider($production->name, $production->link);
            $provider->save();
            //Indica el registro como procesado. Esto ocasiona que la produccion ya no se vuelva a actualizar, hasta una nueva cola. 
            $production->date_processed = DateUtil::getCurrentTime();
            $production->save();
        }
    }

}
