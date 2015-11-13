<?php

use App\System\Models\Production;
use App\System\Library\Complements\Util;

$titles = array(); //Almacena los nombre de las peliculas a mostrar
?>
@extends("frontend/templates/gen",array("id_body"=>"search"))

@section("title")Buscar: {{$query}} @stop


@section("content")

<div class="page-header" style="margin-left:9px;">
    <h2><span class="glyphicon glyphicon-search"></span> {{$query}}</h2>
</div>

@if(count($persons)>0)
<h3 style="margin-left:9px;">Personas</h3>
<div id="persons" class="col-lg-12">
    @foreach($persons as $person)
    <div class="person" title="{{$person->name}}">
        <a href="{{URL::to("person/".$person->slug)}}">
            <div class="image-person"><img class="img-rounded" src="{{$person->image}}"/></div>
            <div class="name-person">{{Util::trimText($person->name,10,null)}}</div>
        </a>
    </div>
    @endforeach
</div>
@endif

<div class="clearfix"></div>

@if(count($productions)>0)
<h3 style="margin-left:9px;">Producciones</h3>
<div class="col-lg-12" style="padding:0px;">
    @foreach($productions as $production)
    @if(!in_array($production->title,$titles))
    {{Production::getVisualHtml($production)}}
    <?php $titles[] = $production->title; ?>
    @endif
    @endforeach
</div>
@else
<div class="jumbotron text-left" style="margin-left:9px;">
    <h1>La búsqueda de "{{$query}}" no tuvo resultados.</h1>
    <p>Sugerencias:</p>
    <p>
    <ul>
        <li>Intenta escribir otras palabras claves</li>
        <li>Intenta escribir parte del título de una producción o su nombre completo.</li>
        <li>Intenta escribir el nombre de un actor/director o parte de él para encontrar sus producciones asociadas.</li>
    </ul>
</p>
</div>
@endif

@stop

