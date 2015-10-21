<?php

use App\System\Library\Complements\Util;
use App\System\Library\Security\Hash;
?><!DOCTYPE html>
<html>
    <head>
        <title>{{$production->title}} | Bandicot.com</title>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <meta name="robots" content="noindex">
        {{-- Bootstrap --}}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap-theme.css', array('media' => 'screen')) }}

        {{--CSS PERSONALIZADO--}}
        {{ HTML::style('assets/css/ui/videoplayer.css', array('media' => 'screen')) }}

        {{-- jQuery (necessary for Bootstraps JavaScript plugins) --}}
        {{ HTML::script('assets/js/jquery.js') }}
        {{ HTML::script('assets/js/jquery-1.10.2.js') }}


        {{-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries --}}
        <!--[if lt IE 9]>
            {{ HTML::script('assets/js/html5shiv.js') }}
            {{ HTML::script('assets/js/respond.min.js') }}
        <![endif]-->
    </head>
    <body>
        <a href="{{URL::to("production/".$production->slug)}}" id="btn-back">
            <span class="glyphicon glyphicon-arrow-left"></span>
        </a>

        <div id="content-video" class="embed-responsive embed-responsive-16by9">
            <iframe src="{{$url_video}}&autostart=true" allowtransparency="true" frameborder="0" scrolling="no"  allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen></iframe>
        </div>


        {{-- Include all compiled plugins (below), or include individual files as needed --}}
        {{ HTML::script('assets/plugins/bootstrap/js/bootstrap.js') }}
        {{ HTML::script('assets/plugins/bootstrap-submenu/js/bootstrap-submenu.js') }}
        {{ HTML::script('assets/js/bootstrap-tooltip.js') }}
        {{ HTML::script('assets/js/ui/videoplayer.js') }}
        <script>;
            jQuery(".tooltip-left").tooltip({placement: "left"});
            jQuery(".tooltip-top").tooltip({placement: "top"});
            jQuery(".tooltip-right").tooltip({placement: "right"});
            jQuery(".tooltip-bottom").tooltip({placement: "bottom"});
        </script>
    </body>
</html>