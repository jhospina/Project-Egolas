@extends("frontend/templates/land")

@section("title"){{$production->title}}@stop

@section("css")

<style>
    body{
        background-image: url("{{$production->poster}}");
        background-size: cover;
        background-position: center;
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
    <a href="{{URL::to("")}}"><img src="{{URL::to("assets/images/logo.png")}}"></a>
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