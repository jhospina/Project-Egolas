<?php

use App\System\Models\Production;
?>
<div class="page-header">
    <h1 class="text-center">¡Disfruta del mejor catalogo de peliculas de internet!</h1>
</div>
<div class="col-sm-6 text-center" style="padding-bottom: 20px;">
    <h2>¿Quieres ver "{{$production->title}}"?</h2>
    <div class="col-sm-12">
        <img width="214" height="317"  class="img-rounded" src="{{$production->image}}" alt="{{$production->title}}">
    </div>
    <div class="clearfix"></div>
    <div class="caption clearfix" style="margin-top:20px;">Para ver esta producción necesitas iniciar sesión con tu cuenta de bandicot y si no tienes, crea una completamente gratis.</div>
    @if($production->state!=Production::STATE_ACTIVE)
    <div class="attention"><b><span class="glyphicon glyphicon-alert"></span> Atención</b></br> Esta producción podria no estar disponible en el momento.</div>
    @endif
</div>

<div class="col-sm-6" id="content-premium">
    <fieldset>
        <h1><span class="glyphicon glyphicon-user"></span> Ingresa a tu cuenta</h1>
        <hr class="colorgraph">
        @include("ui/msg/index",array("message_id"=>1))
        <form action="{{URL::to('user/auth/login')}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="redirect_to" value="{{URL::to('production/'.$production->slug)}}">
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
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="button" onclick="submit(this);" id="submit" class="btn btn-lg btn-success btn-block">Ingresar</button>
            </div>      
        </div>
    </fieldset>
    <h2 class="text-center" style="margin-top:70px;">¿No tienes una cuenta?</h2>
    <div class="text-center">
        <a href="{{URL::to("")}}" class="btn btn-lg btn-primary" id="btn-create-account"></a>
    </div>
</div>

<script src='{{URL::to("assets/scripts/library/validations.js")}}'></script>
<script src='{{URL::to("assets/scripts/user/contents/auth/login.js")}}'></script>