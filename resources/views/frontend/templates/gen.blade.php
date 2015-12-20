<!DOCTYPE html>
<html lang="es">
    <head>
        <title>@yield('title',trans("gen.head.title")) - Bandicot.com</title>
        <meta name="description" content="@yield('meta-description','Disfruta del mejor catalogo de peliculas en internet, miralas online y gratis desde cualquier dispositivo.')">
        <meta name="keywords" content="bandicot, bandicot.com, peliculas, series, gratis, online, reproducir, directores, actores, cine, estrenos, catalogo, dvd">
        <meta name='language' content='es' />
        <meta http-equiv='content-language' content='es' />
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <meta name="author" content="Bandicot.com">
        <meta name='owner' content='Bandicot.com' />
        <meta name='copyright' content='&COPY; Copyright {{date('Y')}} - Todos los derechos reservados' /><meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        @yield("meta-tags")

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        {{-- Bootstrap --}}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap-theme.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/plugins/bootstrap-submenu/css/bootstrap-submenu.css', array('media' => 'screen')) }}

        {{--CSS PERSONALIZADO--}}
        {{ HTML::style('assets/css/templates/gen.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/css/templates/gen-mobile.css', array('media' => 'screen')) }}
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
        <div class='container container text-center' id='legend'><i>{{trans("gen.legend")}}</i></div>
        <footer>
            <div class="container content">
                <div class="col-sm-6">
                    <ul>
                        <li><a href='{{URL::to("doc/terms")}}'>{{trans("gen.doc.terms")}}</a></li>
                        <li><a href='{{URL::to("doc/privacypolicy")}}'>{{trans("gen.doc.privacy.policy")}}</a></li>
                        <li><a href='{{URL::to("doc/cookies-policy")}}'>{{trans("gen.doc.cookies.policy")}}</a></li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <ul>
                        <li><a href='{{URL::to("doc/help")}}'>{{trans("gen.doc.help")}}</a></li>
                        <li><a href='{{trans("gen.social.facebook.link")}}'>Facebook</a></li>
                        <li><a href='{{trans("gen.social.twitter.link")}}'>Twitter</a></li>
                    </ul>
                </div>
                <div class='col-xs-12 text-center' id='copyright'>
                    <i>Bandicot.com - &COPY; {{date("Y")}} Todos los derechos reservados</i>
                </div>
            </div>
        </footer>


        <div class="modal fade" id="modal-view-production" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title text-center" id="view-production-title"></h3>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-12 text-center"><img id="view-production-image" class="img-rounded"></div>
                        <div class="col-sm-12">
                            <a class="btn btn-lg btn-danger btn-block" id="view-production-play"><span class="glyphicon glyphicon-play-circle"></span> VER PELICULA</a>
                            <a class="btn btn-lg btn-primary btn-block" id="view-production-info"><span class="glyphicon glyphicon-exclamation-sign"></span> INFORMACIÓN</a>
                            <h2 id="view-production-title-chapters" style='color:black;display:hidden;'>Capitulos</h2>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


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
            var url_site = "{{URL::to('')}}";
        </script>

        {{--OTROS SCRIPTS--}}
        @yield("script")

        @if(isset($path))
        {{App\System\Library\Complements\Util::getImportJScriptCurrent($path)}}
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