<?php

use App\System\Library\Complements\DateUtil;
?>

@extends("user/templates/gen",array("title"=>"<span class='glyphicon glyphicon-transfer'></span> ".trans("ui.menu.item.contributions")))


@section("content")

<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>




<div class="col-sm-6">
    <h2>¡Apoyanos en Facebook!</h2>
    <div class="msj-social fb">
        <div class="content-image-social">
            <img src="{{URL::to("assets/images/facebook.png")}}">
        </div>
        <div class="description"> Para nosotros seria muy valioso si nos ayudas a crecer. Contribuir no te cuesta nada. Regalanos un "Me gusta".</div>
    </div>
    <div id="facebook-content">
        <div class="fb-like" data-href="{{trans("gen.social.facebook.link")}}" data-share="true" data-layout="button"></div>
    </div>
</div>
<div class="col-sm-6">
    <h2>¡Apoyanos en Twitter!</h2>
    <div class="msj-social twitter">
        <div class="content-image-social">
            <img src="{{URL::to("assets/images/twitter.png")}}">
        </div>
        <div class="description"> Para nosotros seria muy valioso si nos ayudas a crecer. Contribuir no te cuesta nada. Seguinos en Twitter.</div>
    </div>
    <div id="twitter-content">
        <a href="https://twitter.com/bandicotcom" class="twitter-follow-button" data-show-count="false">¡Siguenos en Twitter!</a>
        <script>!function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                if (!d.getElementById(id)) {
                    js = d.createElement(s);
                    js.id = id;
                    js.src = p + '://platform.twitter.com/widgets.js';
                    fjs.parentNode.insertBefore(js, fjs);
                }
            }(document, 'script', 'twitter-wjs');</script>
    </div>
</div>

<div class="col-lg-12" id="table-contributions">
    @if(count($contributions)>0)
    <div class="col-xs-12 text-center" style="margin-top: 20px;margin-bottom: 20px;padding: 0px;">
        <a href="{{URL::to("premium")}}" id="btn-add-contributions" class="btn btn-default" style="font-size: 12pt;">
            <img width="50px" src="{{URL::to("assets/images/logo-premium.png")}}">
            ¿Quieres más tiempo de cuenta premium? Pulsa aquí
        </a>
    </div>
    <table class="table table-striped table-bordered table-responsive">
        <tr><th>{{trans("gen.info.date")}}</th><th class="dir-ip">{{trans("gen.info.ip.address")}}</th><th class="trans-id">Transacción ID</th><th>Metódo de pago</th><th>Monto</th></tr>
        @foreach($contributions as $contribution)
<?php $date = new DateUtil($contribution->date); ?>
        <tr><td>{{$date->getDay()}} de {{$date->getMonth()}} del {{$date->getYear()}}</td><td class="dir-ip">{{$contribution->ip}}</td><td class="trans-id">{{$contribution->transaction_id}}</td><td>{{ucfirst($contribution->method)}}</td><td>{{number_format($contribution->mount,1)}} USD</td></tr>
        @endforeach
    </table>
    @else

    <div class="jumbotron text-center" style="background:none;color:black;">
        <h2>Todavia no has hecho ninguna contribución</h2>
        <p><img src="{{URL::to("assets/images/sad.png")}}"></p>
        <p style="margin-top: 80px;"><a id="btn-new-contribution" href="{{URL::to("premium")}}" class="btn btn-lg btn-primary">
                <img width="50px" src="{{URL::to("assets/images/logo-premium.png")}}">
                ¡Obtén una cuenta premium! Pulsa aquí
            </a></p>
    </div>



    @endif
</div>



@stop