<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title',"Bandicot - El lugar para encontrar lo quieres ver") | Bandicot.com</title>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{-- Bootstrap --}}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap-theme.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/plugins/bootstrap-submenu/css/bootstrap-submenu.css', array('media' => 'screen')) }}

        {{--CSS PERSONALIZADO--}}
        {{ HTML::style('assets/css/templates/gen.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/css/util.css', array('media' => 'screen')) }}
        @yield('css')

        {{-- jQuery (necessary for Bootstraps JavaScript plugins) --}}
        {{ HTML::script('assets/js/jquery.js') }}
        {{ HTML::script('assets/js/jquery-1.10.2.js') }}


        {{-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries --}}
        <!--[if lt IE 9]>
            {{ HTML::script('assets/js/html5shiv.js') }}
            {{ HTML::script('assets/js/respond.min.js') }}
        <![endif]-->

        <link rel="shortcut icon" href="{{URL::to("/assets/images/favicon.png")}}">

    </head>
    <body id="body-{{(isset($id_body))?$id_body:null}}">

        @include("frontend/ui/navbar")

        <div id="main">

            @yield("content")

        </div>
        <div class="clearfix"></div>
        <div class='container container text-center' id='legend'><i>"Si llegaste hasta aquí, celébralo, nunca serás más feliz si hubieras muerto antes"</i></div>
        <footer class="container content">
            <div class="col-xs-6">
                <ul>
                    <li><a href='{{URL::to("doc/terms")}}'>{{trans("gen.doc.terms")}}</a></li>
                    <li><a href='{{URL::to("doc/privacypolicy")}}'>{{trans("gen.doc.privacy.policy")}}</a></li>
                </ul>
            </div>
            <div class="col-xs-6">
                <ul>
                    <li>Bandicot.com</li>
                    <li>&COPY; {{date("Y")}} Todos los derechos reservados</li>
                </ul>
            </div>
        </footer>

        {{-- Include all compiled plugins (below), or include individual files as needed --}}
        {{ HTML::script('assets/plugins/bootstrap/js/bootstrap.js') }}
        {{ HTML::script('assets/plugins/bootstrap-submenu/js/bootstrap-submenu.js') }}
        {{ HTML::script('assets/js/bootstrap-tooltip.js') }}
        {{ HTML::script('assets/scripts/library/searcher.js') }} 
        {{ HTML::script('assets/scripts/frontend/templates/gen.js') }} 

        {{-- MENSAJE MODAL --}}
        @include("ui/msg/modal-message")

        <script>
            jQuery(".tooltip-left").tooltip({placement: "left"});
            jQuery(".tooltip-top").tooltip({placement: "top"});
            jQuery(".tooltip-right").tooltip({placement: "right"});
            jQuery(".tooltip-bottom").tooltip({placement: "bottom"});

        </script>

        {{--OTROS SCRIPTS--}}
        @yield("script")

        @if(isset($path))
        {{App\System\Library\Complements\Util::getImportJScriptCurrent($path)}}
        @endif
    </body>

</html>