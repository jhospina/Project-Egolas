<?php

use App\System\Library\Complements\DateUtil;
?>

@extends("user/templates/gen",array("title"=>"<span class='glyphicon glyphicon-transfer'></span> ".trans("ui.menu.item.contributions")))

@section("content")



<div class="col-lg-12" style="margin-top:20px">
    @if(count($contributions)>0)
    <div class="col-xs-12 text-right" style="margin-top: 20px;margin-bottom: 20px;padding: 0px;">
        <a href="{{URL::to("premium")}}" class="btn btn-default" style="font-size: 12pt;">
            <img width="50px" src="{{URL::to("assets/images/logo-premium.png")}}">
            ¿Quieres otros 2 meses de cuenta premium? Pulsa aquí
        </a>
    </div>
    <table class="table table-striped table-bordered">
        <tr><th>{{trans("gen.info.date")}}</th><th>{{trans("gen.info.ip.address")}}</th><th>Transacción ID</th><th>Metódo de pago</th><th>Monto</th></tr>
        @foreach($contributions as $contribution)
        <?php $date = new DateUtil($contribution->date); ?>
        <tr><td>{{$date->getDay()}} de {{$date->getMonth()}} del {{$date->getYear()}}</td><td>{{$contribution->ip}}</td><td>{{$contribution->transaction_id}}</td><td>{{ucfirst($contribution->method)}}</td><td>{{number_format($contribution->mount,1)}} USD</td></tr>
        @endforeach
    </table>
    @else

    <div class="jumbotron text-center" style="background:none;color:black;">
        <h2>Todavia no has hecho ninguna contribución</h2>
        <p><img src="{{URL::to("assets/images/sad.png")}}"></p>
        <p style="margin-top: 80px;"><a href="{{URL::to("premium")}}" class="btn btn-lg btn-primary" style="font-size: 18pt;">
            <img width="50px" src="{{URL::to("assets/images/logo-premium.png")}}">
            ¡Obtén una cuenta premium! Pulsa aquí
        </a></p>
    </div>
   


    @endif
</div>



@stop