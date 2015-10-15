<?php

use App\System\Models\User;

$data = array(
    "id_body" => "login",
    "path" => "user/contents/auth/recovery"
);

$get_request=isset($_GET["request"])?$_GET["request"]:null;
$get_form=isset($_GET["form"])?$_GET["form"]:null;
?>

@extends("frontend/templates/land",$data)

@section("title")
Recuperar contraseña
@stop

@section("content")


<div id="head-login"></div>

<div class="container">
    <div class="row" style="margin-top:40px">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            @if($get_request=="send-mail" && $get_form=="token")
            <fieldset>
                <h1 class="text-center">¡Solicitud enviada!</h1>
                <hr class="colorgraph">
                @include("ui/msg/index",array("message_id"=>1))
                <p>Se te ha enviado un correo electrónico con un código de seguridad para establecer tu contraseña, cópialo y pégalo en el siguiente campo:</p>
                <form id="form" method="POST" action="{{URL::to("user/auth/recovery/reset/password")}}">
                     {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" name="token" id="token" class="form-control input-lg" placeholder="Código de seguridad" value="">
                        <input type="hidden" name="email" value="{{(session()->has(User::ATTR_EMAIL))?session(User::ATTR_EMAIL):""}}">
                    </div>
                </form>
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="button" onclick="submit(this);" class="btn btn-lg btn-success btn-block">Enviar código</button>
                    </div>
                </div>
            </fieldset>
            @else
            <fieldset>
                <h1 class="text-center">¿Olvidastes tu contraseña?</h1>
                <hr class="colorgraph">
                @include("ui/msg/index",array("message_id"=>1))
                <form action="" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Ingresar el correo electrónico de tu cuenta</label>
                        <input type="email" name="email" id="email" class="form-control input-lg" placeholder="{{trans("gen.info.email")}}" value="{{(session()->has(User::ATTR_EMAIL))?session(User::ATTR_EMAIL):""}}">
                    </div>
                </form>
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="button" onclick="submit(this);" class="btn btn-lg btn-success btn-block">Recuperar contraseña</button>
                    </div>
                </div>
            </fieldset>
            @endif
        </div>
    </div>

</div>
@stop


@section("script")
<script src='{{URL::to("assets/scripts/library/validations.js")}}'></script>
@stop