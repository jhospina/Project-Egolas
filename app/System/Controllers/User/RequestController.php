<?php

namespace App\System\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\System\Library\Complements\UI;
use App\System\Library\Complements\DateUtil;
use App\System\Models\User;
use Illuminate\Http\Request;
use App\System\Models\Request as RequestUser;
use App\System\Models\QueueProductions;
use App\System\Library\Complements\Util;
use App\System\Models\Production;
use App\System\AutoUpdateSearcher\Providers\HTMLProvider;

class RequestController extends Controller {

    function ajax_postAdd(Request $request) {
        if (!$request->ajax())
            return;
        $data = $request->all();
        $url = Util::filtrateUrl($data["url"]);

        //Verifica si existe en la cola de procesamiento
        if (QueueProductions::existsByLink($url)) {
            $queue = QueueProductions::where(QueueProductions::ATTR_LINK, $url)->get()[0];

            //Verifica si ya ha sido procesado
            if (!is_null($queue[QueueProductions::ATTR_DATE_PROCESSED])) {
                $production = Production::find($queue->production_id);
                //Verifica si la produccion ya esta disponible
                if ($production->state == Production::STATE_ACTIVE) {
                    //Produccion ya disponible
                    return json_encode(array("state" => "active", "title" => $production->title, "title_original" => $production->title_original, "image" => $production->image, "link" => url("production/" . $production->slug)));

                    //Aun no disponible
                } else {

                    //Verifica si el usuario ya ha generado una solicitud
                    if (RequestUser::where(RequestUser::ATTR_PRODUCTION_ID, $production->id)->count() > 0)
                        return json_encode(array("error" => "Esta producción ya ha sido solicitada por tí. No lo puedes hacer dos veces."));

                    //Genera una solicitud de produccion
                    $request = new RequestUser;
                    $request->user_id = Auth::user()->id;
                    $request->production_id = $production->id;
                    $request->queue_id = $queue->id;
                    $request->date = DateUtil::getCurrentTime();
                    $request->save();

                    //Genera un seguimiento de notificacion para el usuario
                    Auth::user()->tracks()->attach($production->id);
                    //Produccion procesada en espera por fuentes de video
                    return json_encode(array("state" => "inwait", "title" => $production->title, "title_original" => $production->title_original, "image" => $production->image, "link" => url("production/" . $production->slug)));
                }
                //La produccion esta en cola, pero no ha sido procesada 
            }else {

                //Verifica si el usuario ya ha generado una solicitud
                if (RequestUser::where(RequestUser::ATTR_QUEUE_ID, $queue->id)->count() > 0)
                    return json_encode(array("error" => "Esta producción ya ha sido solicitada por tí. No lo puedes hacer dos veces."));

                //Genera una solicitud de produccion
                $request = new RequestUser;
                $request->user_id = Auth::user()->id;
                $request->production_id = null;
                $request->queue_id = $queue->id;
                $request->date = DateUtil::getCurrentTime();
                $request->save();

                return json_encode(array("state" => "inqueue", "title" => $queue->name));
            }
        } else {

            $html = new HTMLProvider();
            $html->loadContent($url);

            $queue = new QueueProductions;
            $queue->production_id = null;

            $queue->name = null;
            //Obtiene el nombre de la produccion
            if (preg_match_all('/<span[^>]*itemprop=["\']name*["\']\>(.*?)<\/span>/i', $html->htmlContent, $match_title_original, PREG_SET_ORDER))
                $queue->name = strip_tags($match_title_original[0][0]);
            $queue->link = $url;
            $queue->date_creation = DateUtil::getCurrentTime();
            $queue->save();

            //Genera una solicitud de produccion
            $request = new RequestUser;
            $request->user_id = Auth::user()->id;
            $request->production_id = null;
            $request->queue_id = $queue->id;
            $request->date = DateUtil::getCurrentTime();
            $request->save();

            return json_encode(array("state" => "addqueue", "title" => $queue->name));
        }
    }

}
