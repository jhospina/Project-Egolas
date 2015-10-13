<?php

use App\System\Library\Complements\Util;
use \App\System\Models\Dealer;
use App\System\Models\Production;
?>

@extends("frontend/templates/gen")

@section("title"){{$person->name}}@stop

@section("css")
{{ HTML::style('assets/css/frontend/person/info.css', array('media' => 'screen')) }}
@stop

@section("content")

<div id="info" class="content container">
    <div class="col-md-12 title">{{$person->name}}</div>
    <div id="biography" class="col-md-12">
        <p><img class="img-rounded" src="{{$person->image}}"/> {{Util::applyJumpsIntoText($person->biography)}}</p>
    </div>
</div>

<div id="movies" class="content container">
    <div class="col-md-12 title">{{trans("gen.info.movies")}}</div>
    @foreach($productions as $production)
    <div class="content-production">
        <a href="{{URL::to("production/".$production->slug)}}"><img class="tooltip-bottom production {{($production->state!=Production::STATE_ACTIVE)?"production-not-available":null}}" title="{{$production->title}}" src="{{$production->image}}"></a>
    </div>
    @endforeach
</div>


@stop