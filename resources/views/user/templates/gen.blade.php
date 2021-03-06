<!DOCTYPE html>
<html lang="es">
    <head>
        <title>{{(isset($title))?strip_tags($title):"Todo Lo que quieres ver"}} - Bandicot.com</title>
        <meta name="robots" content="NoIndex, NoFollow">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name='language' content='es' />
        {{-- Bootstrap --}}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/plugins/bootstrap/css/bootstrap-theme.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/plugins/bootstrap-submenu/css/bootstrap-submenu.css', array('media' => 'screen')) }}
        {{HTML::style("assets/plugins/fileinput/css/fileinput.css",array("media"=>"screen"))}}

        {{--CSS PERSONALIZADO--}}
        {{ HTML::style('assets/css/util.css', array('media' => 'screen')) }}

        {{ HTML::style('assets/css/templates/user/gen.css', array('media' => 'screen')) }}
        {{ HTML::style('assets/css/templates/user/gen-mobile.css', array('media' => 'screen')) }}

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

        @include("ui/navbar",array("title"=>$title))

        @include("user/ui/menu")

        <div id="main" class="col-xs-10 col-xs-offset-2">
            <div class="page-header title-mobile">
                <h1>{{$title}}</h1>
            </div>
            @yield("content")
        </div>


        {{-- MENSAJE MODAL --}}
        @include("ui/msg/modal-message")

        {{-- Include all compiled plugins (below), or include individual files as needed --}}
        {{ HTML::script('assets/plugins/bootstrap/js/bootstrap.js') }}
        {{ HTML::script('assets/plugins/bootstrap-submenu/js/bootstrap-submenu.js') }}
        {{ HTML::script('assets/js/bootstrap-tooltip.js') }}
        {{ HTML::script('assets/scripts/user/templates/gen.js') }}
        {{HTML::script("assets/plugins/fileinput/js/fileinput.js")}}
        <script>
            jQuery(".tooltip-left").tooltip({placement: "left"});
            jQuery(".tooltip-top").tooltip({placement: "top"});
            jQuery(".tooltip-right").tooltip({placement: "right"});
            jQuery(".tooltip-bottom").tooltip({placement: "bottom"});
            var url_ajax_upload_avatar = "{{URL::to('user/account/ajax/upload/avatar')}}";
            var token_ajax = "{{ Session::token() }}";
        </script>

        {{--OTROS SCRIPTS--}}
        @yield("script")

        @if(isset($path))
        {{App\System\Library\Complements\Util::getImportJScriptCurrent($path)}}
        @endif
    </body>

</html>