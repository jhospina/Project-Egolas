<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\System\AutoUpdateSearcher\Feeds\ProductionFeed;
use App\System\Library\Complements\DateUtil;
use App\System\Models\QueueProductions;
use App\System\AutoUpdateSearcher\Providers\ProductionProvider;
use App\System\Models\AutoProcess;
use App\System\Models\QueuePersons;
use App\System\AutoUpdateSearcher\Providers\PersonProvider;
use App\System\Models\User;
use App\System\Models\Production;
use App\System\Library\Com\Email;

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
                    return "Desactivado";

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
                    return "Desactivado";

                $queue = QueueProductions::where(QueueProductions::ATTR_DATE_PROCESSED, null)->orderBy(QueueProductions::ATTR_ID, "ASC")->take(1)->get();

                foreach ($queue as $production) {
                    $provider = new ProductionProvider($production->name, $production->link);
                    $production_id = $provider->save();
                    //Indica el registro como procesado. Esto ocasiona que la produccion ya no se vuelva a actualizar, hasta una nueva cola.
                    $production->production_id = $production_id;
                    $production->date_processed = DateUtil::getCurrentTime();
                    $production->save();
                    return $production->name . " Agregado";
                }

                return "Sin cola";
            });


            /**
             * CRON: Seguimiento de persona
             * DESCRIPCION: Toma las personas indicadas y las procesa para obtener todos sus datos
             * EJECUCION: Cada minuto
             */
            \Cron::add(AutoProcess::CRON_PERSON_TRACK, '* * * * *', function() {

                if (!AutoProcess::isActived(AutoProcess::CRON_PERSON_TRACK))
                    return "Desactivado";

                $queue = QueuePersons::where(QueuePersons::ATTR_DATE_PROCESSED, null)->orderBy(QueuePersons::ATTR_ID, "DESC")->take(1)->get();

                foreach ($queue as $person) {
                    $provider = new PersonProvider($person->name, $person->link);
                    $provider->save();
                    //Indica el registro como procesado. Esto ocasiona que la produccion ya no se vuelva a actualizar, hasta una nueva cola. 
                    $person->date_processed = DateUtil::getCurrentTime();
                    $person->save();
                    return $person->name . " Agregado";
                }

                return "Sin cola";
            });


            /**
             * CRON: Envio de correo de notificacion de producciones disponibles
             * DESCRIPCION: Verifica todos las producciones en seguimientos por parte de los usuarios premium y cuando esten disponibles les envia un correo notificandoles
             * EJECUCION: Cada 12 horas
             */
            \Cron::add(AutoProcess::CRON_USER_PRODUCTION_TRACK_SEND_MAIL, '* */12 * * *', function() {

                if (!AutoProcess::isActived(AutoProcess::CRON_USER_PRODUCTION_TRACK_SEND_MAIL))
                    return "Desactivado";


                //Obtiene todos los usuarios premium
                $users = User::where(User::ATTR_ROLE, User::ROLE_SUSCRIPTOR_PREMIUM)->get();
                foreach ($users as $user) {
                    //Obtiene las producciones que siguen que ya se encuentran disponibles y que no sean notificado por correo
                    $productions = $user->tracks()->wherePivot(User::ATTR_TRACK_PIVOT_MAILED, 0)->where(Production::ATTR_STATE, Production::STATE_ACTIVE)->get();

                    if (count($productions) == 0)
                        continue;

                    if (count($productions) > 1) {
                        $description_email = "<p>Este mensaje es para informate que varias producciones que te gustaria ver en nuestra plataforma ya se encuentran disponibles y las puedes ver cuando quieras.</p>" .
                                "<div style='text-align:center;'>" .
                                "<h2>Nuevas producciones disponibles para ti</h2>" .
                                "</div>" .
                                "<div style='text-align:center;'>";
                    } else {
                        $description_email = "<p>Este mensaje es para informate que una producción que te gustaria ver en nuestra plataforma ya se encuentran disponible y la puede ver cuando quieras.</p>" .
                                "<div style='text-align:center;'>" .
                                "<h2>Nueva producción disponible para ti</h2>" .
                                "</div>" .
                                "<div style='text-align:center;'>";
                    }

                    foreach ($productions as $production) {
                        //Notifica las producciones disponibles asociadas
                        $description_email.="<a href='" . "http://bandicot.com/production/" . $production->slug . "'><img width='192px' height='289px' style='margin: 0px 10px;' src='" . $production->image . "'></a>";
                        $production->pivot->mailed = 1;
                        $production->pivot->save();
                    }

                    $description_email.="</div>";

                    //Envia el correo de notificacion del usuario
                    $email = new Email((count($productions) > 1) ? "¡Hay varias producciones que te gustaria ver que ya estan disponible!" : "¡Una producción que te gustaria ver ya esta disponible!", $user[User::ATTR_EMAIL], [Email::VAR_NAME => $user->name, Email::VAR_DESCRIPTION => $description_email]);
                    $email->queue();
                }

                return "Notificaciones realizadas (Si aplican)";
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
