<?php

use App\System\Models\User;

$data = array(
    "id_body" => "login",
    "path" => "user/contents/auth/login"
);
?>

@extends("frontend/templates/land",$data)

@section("title")
{{trans("gen.info.login")}}
@stop

@section("content")


<div id="head-login">

</div>

<div class="container">
    <div class="row" style="margin-top:40px">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <fieldset>
                <h1><span class="glyphicon glyphicon-user"></span> Ingresa a tu cuenta</h1>
                <hr class="colorgraph">
                @include("ui/msg/index",array("message_id"=>1))
                <form action="" method="POST">
                    {{ csrf_field() }}
                    @if(isset($_GET["redirect_to"]))
                    <input type="hidden" name="redirect_to" value="{{$_GET["redirect_to"]}}">
                    @endif
                    <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control input-lg" placeholder="{{trans("gen.info.email")}}" value="{{(session()->has(User::ATTR_EMAIL))?session(User::ATTR_EMAIL):""}}">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="{{trans("gen.info.password")}}">
                    </div>
                    <span class="button-checkbox">
                        <button type="button" class="btn" data-color="info">Recordarme</button>
                        <input type="checkbox" name="{{User::AUTH_REMEMBER}}" id="remember_me" checked="checked" class="hidden">
                        <a href="{{URL::to("user/auth/recovery")}}" class="btn btn-link pull-right">¿Olvidaste tu contraseña?</a>
                    </span>
                </form>
                <hr class="colorgraph">

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <button type="button" onclick="submit(this);" id="submit" class="btn btn-lg btn-success btn-block">Ingresar</button>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <a href="{{URL::to("")}}" class="btn btn-lg btn-primary btn-block">Crear una cuenta</a>
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