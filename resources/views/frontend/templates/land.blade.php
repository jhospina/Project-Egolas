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
        <meta name='copyright' content='&COPY; Copyright {{date('Y')}} - Todos los derechos reservados' />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        @yield("meta-tags")

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">

        {{-- Bootstrap --}}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap-theme.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/plugins/bootstrap-submenu/css/bootstrap-submenu.css', array('media' => 'screen')) }}

        {{--CSS PERSONALIZADO--}}
        {{ HTML::style('assets/css/templates/land.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/css/templates/land-mobile.css', array('media' => 'screen')) }}
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

        @yield("content")

        {{-- Include all compiled plugins (below), or include individual files as needed --}}
        {{ HTML::script('assets/plugins/bootstrap/js/bootstrap.js') }}
        {{ HTML::script('assets/plugins/bootstrap-submenu/js/bootstrap-submenu.js') }}
        {{ HTML::script('assets/js/bootstrap-tooltip.js') }}

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