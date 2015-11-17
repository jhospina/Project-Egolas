<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\System\Models\User;
use Illuminate\Support\Facades\Auth;
use App\System\Library\Complements\UI;
use App\System\Models\Production;
use App\System\Library\Complements\DateUtil;

class Notifications {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;
    private $excepts = [];

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!$this->auth->guest()) {
            $this->checkStatePremium($request);
            //Verifica que no halla ningun otro mensaje para mostrar al usuario
            if (!$request->session()->has(UI::SESSION_MODAL_MESSAGE_TITLE))
                $this->newProductionsAvailable($request);
        }

        return $next($request);
    }

    /** Notifica al usuario en sesión que hay produccion disponibles que el usuario deseaba ver
     * 
     * @param type $request
     * @return type
     */
    public function newProductionsAvailable($request) {

        $productions = Auth::user()->tracks()->wherePivot(User::ATTR_TRACK_PIVOT_NOTIFIED, 0)->where(Production::ATTR_STATE, Production::STATE_ACTIVE)->get();

        if (count($productions) == 0)
            return;

        if (count($productions) > 1) {
            $description = "<p>Este mensaje es para informate que varias producciones que te gustaria ver en nuestra plataforma ya se encuentran disponibles y las puedes ver cuando quieras.</p>" .
                    "<div style='text-align:center;'>" .
                    "<h2>Nuevas producciones disponibles para ti</h2>" .
                    "</div>" .
                    "<div class='text-center'>";
        } else {
            $description = "<p>Este mensaje es para informate que una producción que te gustaria ver en nuestra plataforma ya se encuentran disponible y la puede ver cuando quieras.</p>" .
                    "<div style='text-align:center;'>" .
                    "<h2>Nueva producción disponible para ti</h2>" .
                    "</div>" .
                    "<div class='text-center'>";
        }

        foreach ($productions as $production) {
            //Notifica las producciones disponibles asociadas
            $description.="<a href='" . url("production/" . $production->slug) . "'><img class='production-nots' width='192px' height='289px' style='margin: 0px 10px;' src='" . $production->image . "'></a>";
            $production->pivot->notified = 1;
            $production->pivot->save();
        }

        $description.="</div>";


        $request->session()->put(UI::modalMessage((count($productions) > 1) ? "¡Nuevas producciones disponibles!" : "¡Nueva producción disponible!", $description));
    }

    /**
     * Verifica el estado Premium del usuario y su tiempo. 
     */
    public function checkStatePremium($request) {

        $description = "<p class='caption'>Lamentamos informarte que el tiempo de cuenta premium para disfrutar sin limites en bandicot se ha terminado. Queremos agradecerte por usar nuestra plataforma y pasar tu tiempo con nosotros.</p>" .
                "<h2 class='text-center' style='margin-top: 45px;margin-bottom: 30px;'>¿Quieres continuar sin limitaciones con una cuenta premium?</h2>" .
                "<div class='text-center'><img style='width: 23%;' src='" . url("assets/images/logo-premium.png") . "'/><br/><br/><a href='" . url("premium") . "' class='btn btn-primary'><span class='glyphicon glyphicon-arrow-up'></span> ¡Actualizar a cuenta premium!</a></div>";

        if (Auth::user()->role == User::ROLE_SUSCRIPTOR_PREMIUM) {
            $time = DateUtil::difSec(DateUtil::getCurrentTime(), Auth::user()->premium_to);
            if ($time <= 0) {
                Auth::user()->role = User::ROLE_SUSCRIPTOR;
                Auth::user()->save();
                $request->session()->put(UI::modalMessage("<span class='glyphicon glyphicon-time'></span> ¡Tu tiempo de cuenta premium se ha terminado!", $description,"Cerrar"));
            }
        }
    }

}
