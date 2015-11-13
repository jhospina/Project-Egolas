<?php

use App\System\Library\Complements\Util;
use \App\System\Models\Dealer;
use App\System\Models\Production;
?>

@extends("frontend/templates/gen")

@section("title"){{$person->name}}@stop

@section("meta-description")Mira todas las peliculas de {{$person->name}} en un solo lugar. Bandicot te ofrece una gran base de datos de directores y actores de cine con su respectiva biografía.@stop


@section("css")
{{ HTML::style('assets/css/frontend/person/info.css', array('media' => 'screen')) }}
@stop

@section("content")

<div id="info" class="content container">
    <div class="col-md-12 title">{{$person->name}}</div>
    <article id="biography" class="col-md-12">
        <p><img class="img-rounded" alt="{{$person->name}}" src="{{$person->image}}"/> {{Util::applyJumpsIntoText($person->biography)}}</p>
    </article>
</div>

<div id="movies" class="content container">
    <div class="col-md-12 title">{{trans("gen.info.movies")}}</div>
    @foreach($productions as $production)
     {{Production::getVisualHtml($production)}}
    @endforeach
</div>


@stop