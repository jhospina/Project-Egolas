<?php

namespace App\System\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\System\Models\Payment as PayM;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use App\Order;
use App\OrderItem;
use App\System\Library\Complements\UI;
use \Illuminate\Support\Facades\Session;
use App\System\Library\Com\Email;
use App\System\Library\Complements\DateUtil;
use Illuminate\Http\Request;

class PaymentController extends Controller {

    function getIndex() {
        return view("frontend/contents/payment/index");
    }

    private $_api_context;

    public function __construct() {
        // setup PayPal api context
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function postPayment(Request $request) {
        $data = $request->all();
        $error = false;

        //Verificacion de existencia de variables
        if (!isset($data["mount"]) || !isset($data["quantity"]))
            $error = true;
        $mount = round(floatval($data["mount"]), 2);
        $quantity = intval($data["quantity"]);

        //Verificacion del tipo de dato
        if ($quantity <= 0 || $mount <= 0)
            $error = true;
        //Verificacion de cuantias minimas
        if ($quantity < intval(PayM::PAY_MIN_QUANTITY) || $mount < round(floatval(PayM::PAY_PRICE_PER_DAY * PayM::PAY_MIN_QUANTITY), 2))
            $error = true;
        //Verificacion de la integridad de los valores
        if (($mount / $quantity) != PayM::PAY_PRICE_PER_DAY)
            $error = true;

        if ($error)
            return redirect()->back()->with(UI::modalMessage("¡OOUPS ALGO SALIO MAL!", "<div class='text-center'><img width='100px;' src='" . url('assets/images/alert.png') . "'><p style='font-size: 15pt;margin-top:20px;'>Parece que ocurrio un error en la integridad de la información enviada. Por favor intentalo de nuevo. Si el problema persiste intentalo de nuevo más tarde.</p></div>", "¡OK!"));

        $payer = new Payer();

        $payer->setPaymentMethod(PayM::METHOD_PAYPAL);

        $items = array();
        $subtotal = 0;
        $currency = PayM::MONEY_CURRENT;
        $price = $mount;

        //Descripción del item a comprar
        $item = new Item();
        $item->setName(PayM::PAY_NAME)
                ->setCurrency($currency)
                ->setDescription("x " . $quantity . " días")
                ->setQuantity(PayM::PAY_QUANTITY)
                ->setPrice($price);

        $items[] = $item;
        $subtotal = $price;

        //Totales
        $item_list = new ItemList();
        $item_list->setItems($items);
        $details = new Details();
        $details->setSubtotal($subtotal);
        $total = $subtotal;

        $amount = new Amount();
        $amount->setCurrency($currency)
                ->setTotal($total)
                ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription("Bandicot.com");

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(url('premium/payment/status'))
                ->setCancelUrl(url('premium/payment/status'));
        
        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));


        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                exit;
            } else {
                return redirect()->back()->with(UI::modalMessage("¡OOUPS ALGO SALIO MAL!", "<div class='text-center'><img width='100px;' src='" . url('assets/images/alert.png') . "'><p style='font-size: 15pt;margin-top:20px;'>Parece que ocurrio un error al tratar de conectarse con el servidor pagos Paypal. Por favor intentalo de nuevo. Si el problema persiste intentalo de nuevo más tarde.</p></div>", "¡OK!"));
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());
        Session::put('payment_quantity', $quantity);
        
        if (isset($redirect_url)) {
            // redirect to paypal
            return \Redirect::away($redirect_url);
        }

        return redirect()->back()->with(UI::modalMessage("¡OOUPS ALGO SALIO MAL!", "<div class='text-center'><img width='100px;' src='" . url('assets/images/alert.png') . "'><p style='font-size: 15pt;margin-top:20px;'>Parece que ocurrio un error al tratar de conectarse con el servidor pagos Paypal. Por favor intentalo de nuevo. Si el problema persiste intentalo de nuevo más tarde.</p></div>", "¡OK!"));
    }

    /** Recibe la peticion del estado de la transaccion realizada
     * 
     * @return type
     */
    public function getStatus() {
        // Get the payment ID before session clear
        $payment_id = \Session::get('paypal_payment_id');
        $payment_quantity=Session::get('payment_quantity');
        // clear the session payment ID
        Session::forget('paypal_payment_id');

        $payerId = isset($_GET['PayerID']) ? $_GET['PayerID'] : null;
        $token = isset($_GET['token']) ? $_GET['token'] : null;

        if (is_null($payerId) || is_null($token)) {
            return redirect()->back()->with(UI::modalMessage("Pago cancelado", "<div class='text-center'><img width='150px;' src='" . url('assets/images/sad.png') . "'><p style='font-size: 15pt;margin-top:20px;'>Parece ser que has cancelado el pago. ¿Quieres intentarlo de nuevo?</p></div>", "Cerrar"));
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution, $this->_api_context);


        if ($result->getState() == 'approved') {
            PayM::newRecord($token, $payerId, $payment_id,$payment_quantity);
            $date = new DateUtil(Auth::user()->premium_to);
            $message = view("ui/msg/contents/muchas-gracias-usuario")->with("date_premium", $date->getDay() . " de " . $date->getMonth() . " del " . $date->getYear())->render();
            $email = new Email("¡Gracias " . Auth::user()->name . " por tu aporte!", Auth::user()->email);
            $email->setDescription($message);
            $email->setName(Auth::user()->name);
            //Envia un correo de agredecimiento
            $email->queue();
            return redirect("user/contributions")->with(UI::modalMessage("Pago realizado. ¡Muchas gracias " . Auth::user()->name . "!", $message, "De nada, es un placer"));
        }

        return redirect()->back()->with(UI::modalMessage("ERROR", "<div class='text-center'><img width='150px;' src='" . url('assets/images/alert.png') . "'><p style='font-size: 15pt;margin-top:20px;'>Parece que hubo un problema al realizar el pago. ¿No tienes fondos?</p></div>", "Cerrar"));
    }

}
