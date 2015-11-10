<?php

namespace App\System\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\System\Library\Complements\GoogleTranslate;
use stdClass;
use App\System\Models\User;
use Illuminate\Support\Facades\Auth;
use App\System\Models\Production;
use Illuminate\Support\Facades\DB;
use App\System\Models\Payment;
use App\System\Models\QueueProductions;
use App\System\AutoUpdateSearcher\Providers\ProductionProvider;
use App\System\Library\Complements\DateUtil;

class DashboardController extends Controller {

    function index() {
/*        
          $queue = QueueProductions::where(QueueProductions::ATTR_DATE_PROCESSED, null)->orderBy(QueueProductions::ATTR_ID, "ASC")->take(1)->get();

                foreach ($queue as $production) {
                    $provider = new ProductionProvider($production->name, $production->link);
                    $provider->save();
                    //Indica el registro como procesado. Esto ocasiona que la produccion ya no se vuelva a actualizar, hasta una nueva cola.
                    $production->date_processed = DateUtil::getCurrentTime();
                    $production->save();
                    return $production->name . " Agregado";
                }
        return; */
        
        $users_state = array(User::all()->where(User::ATTR_STATE, User::STATE_ACTIVED_ACCOUNT)->count(), User::all()->where(User::ATTR_STATE, User::STATE_ACTIVED_ACCOUNT)->count());
        $users_role = array(User::all()->where(User::ATTR_ROLE, User::ROLE_SUSCRIPTOR)->count(), User::all()->where(User::ATTR_ROLE, User::ROLE_SUSCRIPTOR_PREMIUM)->count());
        $productions = array(Production::all()->where(Production::ATTR_STATE, Production::STATE_ACTIVE)->count(), Production::whereNotIn(Production::ATTR_STATE, array(Production::STATE_ACTIVE))->count());
        $total_playbacks = DB::table("playbacks")->count();
        $total_ratings = DB::table("production_ratings")->count();
        $total_comments = DB::table("comments")->count();
        $total_payments = Payment::all()->sum(Payment::ATTR_MOUNT);

        return view("manager/contents/dashboard")
                        ->with("users_state", $users_state)
                        ->with("users_role", $users_role)
                        ->with("productions", $productions)
                        ->with("total_playbacks", $total_playbacks)
                        ->with("total_ratings", $total_ratings)
                        ->with("total_comments", $total_comments)
                        ->with("total_payments", $total_payments)
        ;
    }

}
