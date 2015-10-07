<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title',"Bandicot - El lugar para encontrar lo quieres ver") | Bandicot.com</title>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
       
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{-- Bootstrap --}}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap-theme.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/plugins/bootstrap-submenu/css/bootstrap-submenu.css', array('media' => 'screen')) }}

        {{--CSS PERSONALIZADO--}}
        {{ HTML::style('assets/css/templates/gen.css', array('media' => 'screen')) }}

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
    <body>

        @include("ui/navbar")

        <div id="main">
        
        @yield("content")
        
        </div>
        
        
        <footer>
            
        </footer>

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
    </body>

</html>