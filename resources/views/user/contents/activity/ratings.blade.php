<?php

use App\System\Models\Production;
use App\System\Library\Complements\DateUtil;
?>
@extends("user/templates/gen",array("title"=>"<span class='glyphicon glyphicon-time'></span> Actividad: Puntuaciones"))

@section("content")


@foreach($ratings as $rating)

<?php
$production = Production::findOrNew($rating->production_id);
$date = new DateUtil($rating->date);
?>
<div class="col-sm-3 date-activity">{{$date->getDay()}} de {{$date->getMonth()}} del {{$date->getYear()}}</div>
<div class="col-sm-9 description-activity">Puntuaste <img class="tooltip-top" title="{{trans("attr.production.rating.rating_".$rating->rating)}}" width="20px" src="{{URL::to("assets/images/ratings/".$rating->rating.".png")}}"> a <a target="_blank" href="{{URL::to("production/".$production->slug)}}">{{$production->title}}</a>.
</div>


@endforeach

<div class="text-center clearfix">
    {{$ratings->render()}}
</div>

@stop