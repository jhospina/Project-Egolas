<?php

use App\System\Models\User;
use App\System\Models\PasswordReset;

$data = array(
    "id_body" => "login",
    "path" => "user/contents/auth/resetPassword"
);
?>

@extends("frontend/templates/land",$data)

@section("title")
Reiniciar contraseña
@stop

@section("content")


<div id="head-login"></div>

<div class="container">
    <div class="row" style="margin-top:40px">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <fieldset>
                <h1 class="text-center">Ya puedes reiniciar tu contraseña</h1>
                <hr class="colorgraph">
                @include("ui/msg/index",array("message_id"=>1))
                <form action="{{URL::to("user/auth/recovery/reset/password/post")}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="email" value="{{(isset(${PasswordReset::ATTR_EMAIL}))?${PasswordReset::ATTR_EMAIL}:""}}">
                    <input type="hidden" name="token" value="{{(isset(${PasswordReset::ATTR_TOKEN}))?${PasswordReset::ATTR_TOKEN}:""}}">

                    <div class="form-group">
                        <input type="password" name="password" id="pass" class="form-control input-lg" placeholder="Nueva contraseña" value="">
                    </div>
                    <div class="form-group">
                        <input type="password" id="pass-rep" class="form-control input-lg" placeholder="Repetir nueva contraseña" value="">
                    </div>
                </form>
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="button" onclick="submit(this);" class="btn btn-lg btn-success btn-block">Terminar</button>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

</div>
@stop


@section("script")
<script src='{{URL::to("assets/scripts/library/validations.js")}}'></script>
@stop