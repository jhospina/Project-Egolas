<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\System\AutoUpdateSearcher\Feeds\ProductionFeed;
use App\System\Library\Complements\DateUtil;
use App\System\Models\QueueProductions;
use App\System\AutoUpdateSearcher\Providers\ProductionProvider;
use App\System\Models\AutoProcess;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        parent::boot();

        \Blade::setRawTags('{{', '}}');
        $this->cron();
    }

    private function cron() {

        \Event::listen('cron.collectJobs', function() {
            /**
             * CRON: Alimentación de cola de producciones
             * DESCRIPCION: Alimenta la cola de producciones que se van a procesar
             * EJECUCION: Cada 3 minutos
             */
            \Cron::add(AutoProcess::CRON_PRODUCTIONS_FEED, '*/3 * * * *', function() {

                if (!AutoProcess::isActived(AutoProcess::CRON_PRODUCTIONS_FEED))
                    exit();

                $productionFeed = new ProductionFeed();
                //Carga datos de producciones (peliculas) en el repositorio
                $productionFeed->loadRepository();
                //Alimenta la cola de actualizaciones de peliculas
                $productionFeed->feedQueue();
                return count($productionFeed->dataRepository) . " Producciones cargadas en cola";
            });

            /**
             * CRON: Seguimiento de produccion
             * DESCRIPCION: Toma las producciones en cola indicadas y las procesa obtienendo todos los datos de la produccion
             * EJECUCION: Cada minuto
             */
            \Cron::add(AutoProcess::CRON_PRODUCTION_TRACK, '* * * * *', function() {

                if (!AutoProcess::isActived(AutoProcess::CRON_PRODUCTION_TRACK))
                    exit();

                $queue = QueueProductions::where(QueueProductions::ATTR_DATE_PROCESSED, null)->orderBy(QueueProductions::ATTR_ID, "ASC")->take(1)->get();

                foreach ($queue as $production) {
                    $provider = new ProductionProvider($production->name, $production->link);
                    $provider->save();
                    //Indica el registro como procesado. Esto ocasiona que la produccion ya no se vuelva a actualizar, hasta una nueva cola. 
                    $production->date_processed = DateUtil::getCurrentTime();
                    $production->save();
                    return $production->name . " Agregado";
                }
            });
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}