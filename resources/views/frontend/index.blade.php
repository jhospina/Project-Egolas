<?php

use App\System\Models\User;
?>

@extends("frontend/templates/land",array("path"=>"frontend/index"))


@section("css")

<meta name="google-site-verification" content="YTbafZ_EYNhESZojzcwOERfVFovPxifxSvl-BIXdgfE" />

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','//connect.facebook.net/en_US/fbevents.js');

fbq('init', '1080133548684487');
fbq('track', "PageView");
fbq('track', 'CompleteRegistration');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1080133548684487&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

@stop

@section("content")

<nav class="navbar navbar-inverse" id="navbar">
    <a id="btn-mobile-login" href="{{URL::to("user/auth/login")}}"><span class="glyphicon glyphicon-log-in"></span></a>
    <div class="navbar-header">
        <a class="navbar-brand" href="{{URL::to("")}}">
            <img id="logo" alt="Logo Bandicot.com" src="{{URL::to("assets/images/logo.png")}}">
            <img id="logo-mobile" alt="Logo Bandicot.com" src="{{URL::to("assets/images/logo-mobile.png")}}">
        </a>
    </div>
    <div class="collapse navbar-collapse" style="text-align: right;">
        <a href="{{URL::to("user/auth/login")}}" id="btn-login-f" class="btn btn-default"><span class="glyphicon glyphicon-log-in"></span> {{trans("gen.info.login")}}</a>
    </div>
</nav>

<div id="background">
    @foreach($productions as $production)
    <div class="poster">
        <img src="{{$production->image}}" alt="{{$production->title}}">
        <div class="spinner"></div>
    </div>
    @endforeach
</div>

<div id="overligth">
</div>

<div id="content-main">

    <div class="col-lg-6">

        <div class="jumbotron" style="background: none;">
            <h1>¡Disfruta del mejor catalogo de peliculas de internet!</h1>
            <ul style="font-size: 16pt;">
                <li>Peliculas en calidad de DVD</li>
                <li>¡Puedes verlas completamente gratis!</li>
                <li>Desde casi cualquier dispositivo</li>
                <li>Todo el contenido 100% en español</li>
                <li>Hazle seguimiento a los proximos estrenos</li>
                <li>¿Deseas ver una pelicula y no esta disponible? ¡Solicitala!</li>
                <li>Sin publicidad molesta</li>
            </ul>
            <p><a class="btn btn-danger btn-lg" href="{{URL::to('catalogue')}}" role="button"><span class="glyphicon glyphicon-th"></span> Ver catalogo</a></p>
        </div>

    </div>
    <div class="col-lg-6">

        <div class="row">
            <div id="content-form" class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <form  action="{{URL::to('user/post/create/account')}}" method="POST">
                    {{ csrf_field() }}
                    <h2 class="text-center">¡Crea tu cuenta gratis!</h2>
                    <hr class="colorgraph">
                    @if(session()->has("error"))
                    <div class="alert alert-danger">
                        {{session("error")}}
                    </div>
                    @endif
                    @if(session()->has("error-captcha"))
                    <div class="alert alert-danger">
                        {{session("error-captcha")}}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="{{User::ATTR_NAME}}" id="{{User::ATTR_NAME}}" class="form-control input-lg" placeholder="Nombre" tabindex="1" value="{{(session()->has(User::ATTR_NAME))?session(User::ATTR_NAME):""}}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="{{User::ATTR_LASTNAME}}" id="{{User::ATTR_LASTNAME}}" class="form-control input-lg" placeholder="Apellido" tabindex="2" value="{{(session()->has(User::ATTR_LASTNAME))?session(User::ATTR_LASTNAME):""}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" name="{{User::ATTR_EMAIL}}" id="{{User::ATTR_EMAIL}}" class="form-control input-lg" placeholder="Correo electrónico" tabindex="4" value="{{(session()->has(User::ATTR_EMAIL))?session(User::ATTR_EMAIL):""}}">
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Contraseña" tabindex="5">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg" placeholder="Confirmar Contraseña" tabindex="6">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            Al hacer clic en el botón <i>"Registrarme"</i>, tu aceptas haber leido y aceptado los <a href="#" data-toggle="modal" data-target="#t_and_c_m">{{trans("gen.doc.terms")}}</a>, la <a href="#" data-toggle="modal" data-target="#t_and_c_privacy">{{trans("gen.doc.privacy.policy")}}</a> y ademas la <a target="_blank" href="{{URL::to("doc/cookies-policy")}}">{{trans("gen.doc.cookies.policy")}}</a> para el uso de nuestro plataforma web.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12" style="padding: 10px;text-align: center;">
                            <div class="g-recaptcha" data-sitekey="6LdEcQ4TAAAAANULfMhMKz8wvgxzjM8kcUnpsjuv"></div>
                        </div>
                    </div>
                </form>
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-12 col-md-12"><button type="button" onClick="submit(this);" class="btn btn-primary btn-block btn-lg">Registrarme</button></div>
                </div>
            </div>
        </div>

    </div>


</div>


<!-- Modal - TERMS -->
<div class="modal fade"  id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="color:black;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 class="modal-title" >{{trans("gen.doc.terms")}}</h1>
            </div>
            <div class="modal-body text-justify">
                @include("doc/terms")
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Acepto</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal - PRIVACY -->
<div class="modal fade"  id="t_and_c_privacy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="color:black;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 class="modal-title" >{{trans("gen.doc.privacy.policy")}}</h1>
            </div>
            <div class="modal-body text-justify">
                @include("doc/privacy-policy")
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Acepto</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop

@section("script")

<script src='https://www.google.com/recaptcha/api.js'></script>
<script src='{{URL::to("assets/scripts/library/validations.js")}}'></script>

@stop