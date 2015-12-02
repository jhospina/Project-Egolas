<?php

use App\System\Library\Complements\Util;
use App\System\Library\Security\Hash;
use App\System\Library\Detection\MobileDetect;
use App\System\Library\Media\Video;

$detect = new MobileDetect();
$isMobile = ($detect->isMobile() || $detect->isTablet());
?><!DOCTYPE html>
<html>
    <head>
        <title>{{$production->title}} | Bandicot.com</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        {{-- Bootstrap --}}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap-theme.css', array('media' => 'screen')) }}

        {{--CSS PERSONALIZADO--}}
        {{ HTML::style('assets/css/ui/videoplayer.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/css/ui/videoplayer-mobile.css', array('media' => 'screen')) }}

        {{-- jQuery (necessary for Bootstraps JavaScript plugins) --}}
        {{ HTML::script('assets/js/jquery.js') }}
        {{ HTML::script('assets/js/jquery-2.1.4.min.js') }}

        <link rel="shortcut icon" href="{{URL::to("/assets/images/favicon.png")}}">

        @if($isMobile)
        <style>
            div#curtain {
                background: rgba(0, 0, 0, 0.9);
            }
        </style>
        @endif

        {{-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries --}}
        <!--[if lt IE 9]>
            {{ HTML::script('assets/js/html5shiv.js') }}
            {{ HTML::script('assets/js/respond.min.js') }}
        <![endif]-->

        <style>
            body{
                background-image: url("{{$production->poster}}");
                background-size: cover;
                background-position: center;
            }
        </style>

    </head>
    <body>

        <div id="curtain">
            <div id="loader">
                <div class="spinner"></div>
                <div id="msg-loader">Espera por favor...</br> Obteniendo fuentes de video de <i>"{{$production->title}}"</i></div>
            </div>
        </div>

        @if($isMobile)

        <iframe id="video" style='width: 100%;height:100%;' allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>

        <div id="nots-rotate">
            <section>
                <img src="{{URL::to("assets/images/rotate.png")}}">
                <h2>Para una mejor experiencia, por favor gire su dispositivo de forma horizontal.</h2>
            </section>
        </div>

        <script>
            var portrait = false;
            $(document).ready(function () {
                if ($(window).height() > $(window).width())
                {
                    $("iframe").remove();
                    portrait = true;
                }

                window.onresize = function () {
                    if (portrait) {
                        if ($(window).height() < $(window).width())
                            location.reload();
                    }
                }
            });
        </script>

        @else

        <a href="{{URL::to("production/".$production->slug)}}" id="btn-back">
            <span class="glyphicon glyphicon-arrow-left"></span>
        </a>
        <video id='video'></video>

        <div id="barProgress">
            <div class="content-bar">
                <div id="bar-time"></div>
            </div>
            <div id="time">
                NaN
            </div>
        </div>
        <div id="controls">
            <div id="left">
                <section>
                    <div id="play" data-state="pause" class="driver"><span class="glyphicon glyphicon-pause"></span></div>
                </section>
                <section>
                    <div id="volumen-control">
                        <div id="content-volumen">
                            <div id="progress-vol"></div>
                            <div id="market-vol"></div>
                        </div>
                    </div>
                    <div id="sound" class="driver"><span class="glyphicon glyphicon-volume-down"></span></div>
                    <div id="title-video" class="driver">
                        {{$production->title}}
                    </div>
                </section>
            </div>
            <div id="right">
                <section>
                    <div id="full-screen" data-fullscreen="false" class="driver"><span class="glyphicon glyphicon-fullscreen"></span></div>
                </section>
            </div>
        </div>

        @endif

        {{-- Include all compiled plugins (below), or include individual files as needed --}}
        {{ HTML::script('assets/plugins/bootstrap/js/bootstrap.js') }}
        {{ HTML::script('assets/plugins/bootstrap-submenu/js/bootstrap-submenu.js') }}
        {{ HTML::script('assets/js/bootstrap-tooltip.js') }}

        <script language="Javascript">
            var id_video = "{{$id_video}}";
            var production_id = "{{$production->id}}"
            var search_video = "{{URL::to('production/ajax/get/video')}}";
            var poster = "{{$production->poster}}";
            var token = "{{Session::token()}}";
            var time = 0;
            var production_url = "{{URL::to('production/'.$production->slug.'/play/')}}";
            var token_parent = "";
            document.oncontextmenu = function () {
                return false
            }

        </script>
        @if($isMobile)
        {{ HTML::script('assets/js/ui/videoplayer-mobile.js') }}
        @else
        {{ HTML::script('assets/js/ui/videoplayer.js') }}
        @endif

        
        
        
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-39740132-5', 'auto');
            ga('send', 'pageview');

        </script> 
        
        
    </body>
</html>