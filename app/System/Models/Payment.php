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
    const PAY_NAME = "Cuenta premium - Bandicot.com";
    const PAY_DESCRIPTION = "Contribución voluntaria - Donación";
    const PAY_PRICE = "gen.price.cuant";
    const PAY_QUANTITY = 1;

    static function newRecord($token, $payer_id, $transaction_id) {
        $current_time = DateUtil::getCurrentTime();

        $user = Auth::user();
        $pay = new Payment;
        $pay->user_id = $user->id;
        $pay->method = Payment::METHOD_PAYPAL;
        $pay->mount = floatval(trans(Payment::PAY_PRICE));
        $pay->transaction_id = $transaction_id;
        $pay->ip = Util::getIP();
        $pay->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $pay->date = $current_time;
        $pay->token = $token;
        $pay->payer_id = $payer_id;
        $pay->save();

        $user->role = User::ROLE_SUSCRIPTOR_PREMIUM;
        $user->premium_to = (is_null($user->premium_to)) ? (new DateUtil($current_time))->addMonths(2) : (new DateUtil($user->premium_to))->addMonths(2);
        $user->save();
    }

}
