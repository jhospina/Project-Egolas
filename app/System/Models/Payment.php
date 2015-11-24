<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Model;
use App\System\Library\Complements\Util;
use App\System\Library\Complements\DateUtil;
use Illuminate\Support\Facades\Auth;

class Payment extends Model {

    public $timestamps = false;

    const ATTR_ID = "id";
    const ATTR_USER_ID = "user_id";
    const ATTR_METHOD = "method";
    const ATTR_MOUNT = "mount";
    const ATTR_TRANSATION_ID = "transaction_id";
    const ATTR_IP = "ip";
    const ATTR_USER_AGENT = "user_agent";
    const ATTR_DATE = "date";
    const ATTR_TOKEN = "token";
    const ATTR_PAYER_ID = "payer_id";
    //PARAMETROS
    const METHOD_PAYPAL = "paypal";
    const MONEY_CURRENT = "USD";
    const PAY_NAME = "Cuenta premium";
    const PAY_DESCRIPTION = "Disfruta sin limites en bandicot.com";
    const PAY_PRICE_PER_DAY = 0.13; // El precio por dia de cuenta premium (USD)
    const PAY_MIN_QUANTITY = 30; // Cantidad minima a pagar
    const PAY_QUANTITY = 1;

    static function newRecord($token, $payer_id, $transaction_id, $quantity) {
        $current_time = DateUtil::getCurrentTime();

        $user = Auth::user();
        $pay = new Payment;
        $pay->user_id = $user->id;
        $pay->method = Payment::METHOD_PAYPAL;
        $pay->mount = Payment::PAY_PRICE_PER_DAY * $quantity;
        $pay->quantity = $quantity;
        $pay->transaction_id = $transaction_id;
        $pay->ip = Util::getIP();
        $pay->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $pay->date = $current_time;
        $pay->token = $token;
        $pay->payer_id = $payer_id;
        $pay->save();

        $user->role = User::ROLE_SUSCRIPTOR_PREMIUM;
        $user->premium_to = (is_null($user->premium_to)) ? (new DateUtil($current_time))->addDays($quantity) : (new DateUtil($user->premium_to))->addDays($quantity);
        $user->save();
    }

}
