<?php

use App\System\Models\Payment;
?>

@extends("frontend/templates/gen",array("id_body"=>"payment-index","path"=>"frontend/contents/payment/index"))

@section("title") ¡Obtén una cuenta premium! @stop

@section("css")
{{ HTML::style('assets/css/frontend/payment.css', array('media' => 'screen')) }}
@stop

@section("content")

<div class="text-center container content" id='index-payment'>
    <div class="jumbotron text-center">
        <h1>¡Obtén una cuenta premium y disfruta sin limites!</h1>
        <p class="resalt">Para mantener nuestra plataforma libre de publicidad, para el sostenimiento de nuestros servidores y del equipo de trabajo, te pedimos que contribuyas con nosotros dejandonos 
            tu aporte. Desde {{trans("gen.price.cuant")}} USD, con el cual obtendras {{Payment::PAY_MIN_QUANTITY}} días de cuenta premium  sin limites ni restricciones como recompensa por tu contribución.</p>
    </div>
    <img id='logo-premium' src="{{URL::to("assets/images/logo-premium.png")}}">
    <div class="jumbotron text-center">
        <h1>¡Disfruta de {{Payment::PAY_MIN_QUANTITY}} días sin limites por solo {{trans("gen.price.cuant")}} USD!</h1>
        <h3 class="text-left">Beneficios de una cuenta premium:</h3>
        <p>
        <ul>
            <li>Reproduce y disfrutar de todo el contenido de producciones disponible sin limitaciones.</li>
            <li>Accede a la funcionalidad de seguimiento de estrenos y de producciones aun no disponibles.</li>
            <li>Solicita producciones que desees ver y no encuentres en el catalogo.</li>
        </ul>
        </p>
    </div>
    <div class="jumbotron text-center" style="border-top: 1px gray solid;">
        <h1 style="margin-bottom: 35px;">¿Con cuánto quieres contribuir?</h1>
        <p style="font-weight: 300;">Ajusta los valores para indicar la cantidad de días de cuenta premium que deseas o la cantidad de dinero que dispongas. </p>
        <div class="col-sm-6"  id="contributions">
            <h2>Valores ajustables</h2>
            <div class="col-xs-6 text-right">
                <div class="box-contributions">
                    <button type="button" class="btn-up" id="quantity-days-up"><span class="glyphicon glyphicon-triangle-top"></span></button>
                    <div class="quantity"><div class="unid">Días</div><div id="quantity-days" class="mount">{{Payment::PAY_MIN_QUANTITY}}</div></div>
                    <button type="button" class="btn-down" id="quantity-days-down"><span class="glyphicon glyphicon-triangle-bottom"></span></button
                </div>
            </div>
        </div>
        <div class="col-xs-6 text-left">
            <div class="box-contributions">
                <button type="button" class="btn-up" id="quantity-mount-up"><span class="glyphicon glyphicon-triangle-top"></span></button>
                <div class="quantity"><div class="unid">USD</div><div id="quantity-mount" class="mount">{{(Payment::PAY_PRICE_PER_DAY*Payment::PAY_MIN_QUANTITY)}}</div></div>
                <button type="button" class="btn-down" id="quantity-mount-down"><span class="glyphicon glyphicon-triangle-bottom"></span></button>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <h2>Detalles</h2>
        <p class="resalt text-left"><span class="glyphicon glyphicon-piggy-bank"></span> Cada día premium cuesta {{Payment::PAY_PRICE_PER_DAY}} USD</p>
        <p class="resalt text-left"><span class="glyphicon glyphicon-hourglass"></span> La cantidad minima es de {{Payment::PAY_MIN_QUANTITY}} días</p>
    </div>
</div>
<div class="clearfix"></div>
<div id="result">
    ¡Obtendras <span class="days">{{Payment::PAY_MIN_QUANTITY}}</span> días de cuenta premium por <span class="mount">{{(Payment::PAY_PRICE_PER_DAY*Payment::PAY_MIN_QUANTITY)}}</span> USD! 
</div>
<div class="clearfix"></div>
<div class="page-header" style="color:black;border-top: 1px gray solid;">
    <h1>Metodos de pago</h1>
</div>
<form id="form" action="{{URL::to('premium/payment/post')}}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" id="mount" name="mount" value="{{(Payment::PAY_PRICE_PER_DAY*Payment::PAY_MIN_QUANTITY)}}">
    <input type="hidden" id="quantity" name="quantity" value="{{Payment::PAY_MIN_QUANTITY}}">
    <div id="response-redirect" class="col-xs-12" style="color: #878787;display:none;"><h3>Seras redirigido a Paypal...</h3></div>
    <div id="btn-pay" class="btn btn-primary">
        <section><span class="glyphicon glyphicon-credit-card"></span> Pagar con</section>
        <img src="{{URL::to('assets/images/paypal.jpg')}}"/>
    </div>
</form>
</form>
</div>

@stop

@section("script")

<script>
    var quantity_min = "{{Payment::PAY_MIN_QUANTITY}}";
    var price_per_day = "{{Payment::PAY_PRICE_PER_DAY}}";
    $(document).ready(function () {
        $("#btn-pay").click(function () {
            $("#response-redirect").show();
            $("#btn-pay section").html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Espera...");
            $(this).attr("disabled");
            $(this).addClass("disabled");
            $("#form").submit();
        });
    });
</script>

@stop