@extends("frontend/templates/land")

@section("title"){{$production->title}}@stop


@section("meta-description")Ver online gratis {{$production->title}}: {{$production->description}} @stop

@section("css")

<style>
    body{
        background-image: url("{{$production->poster}}");
        background-size: cover;
        background-position: center;
    }

    .attention{
        font-family: calibri;font-size: 14pt;margin-top: 10px;text-align: center;
    }
</style>

@if(isset($css))
@if(is_array($css))
@for($i=0;$i<count($css);$i++)
    <link media="screen" type="text/css" rel="stylesheet" href="{{URL::to($css[$i])}}">
    @endfor
    @else
    <link media="screen" type="text/css" rel="stylesheet" href="{{URL::to($css)}}">
    @endif
    @endif

    @stop

    @section("content")

    <div id="logo-msg-forbidden" class="container content text-center">
        <a href="{{URL::to("")}}"><img alt="Logo Bandicot.com" src="{{URL::to("assets/images/logo.png")}}"></a>
    </div>

    <div id="msg-forbidden" class="container content">
        {{$message}}
    </div>

    @stop


    @section("script")

    @if(isset($script))
    @if(is_array($script))
    @for($i=0;$i<count($script);$i++)
    <script src="{{URL::to($script[$i])}}"></script>
        @endfor
        @else
        <script src="{{URL::to($script)}}"></script>
        @endif
        @endif


        @stop