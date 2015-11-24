@extends("frontend/templates/land")

@section("title"){{$production->title}}@stop


@section("meta-description")Ver Online Gratis "{{$production->title}}": {{$production->description}} @stop


@section("meta-tags")
<meta property="og:type" content="video.movie" />
<meta property="og:title" content="{{$production->title}}" />
<meta property="og:description" content="{{$production->title}}: {{$production->description}}" />
<meta property="og:url" content="{{URL::to("production/".$production->slug)}}" />
<meta property="og:image" content="{{$production->image}}" />
<meta property="og:site_name" content="Bandicot.com - {{trans("gen.head.title")}} " />
<meta property="og:locale" content="es_ES" />
@stop

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

    <div id="msg-forbidden" class="container content" style="margin-bottom: 50px;">
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