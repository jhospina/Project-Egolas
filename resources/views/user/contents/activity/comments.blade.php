<?php

use App\System\Models\Production;
use App\System\Library\Complements\DateUtil;
?>
@extends("user/templates/gen",array("title"=>"<span class='glyphicon glyphicon-time'></span> Actividad: Comentarios"))

@section("content")


@foreach($comments as $comment)

<?php
$production = Production::findOrNew($comment->production_id);
$date = new DateUtil($comment->created_at);
?>
<div class="col-sm-3 date-activity">{{$date->getDay()}} de {{$date->getMonth()}} del {{$date->getYear()}}</div>
<div class="col-sm-9 description-activity">
    <span class="glyphicon glyphicon-comment tooltip-top" style="color:#0072FF;" title="{{$comment->content}}"></span>
    Realizaste un comentario en <a target="_blank" href="{{URL::to("production/".$production->slug)}}">{{$production->title}}</a>.
</div>


@endforeach

<div class="text-center clearfix">
    {{$comments->render()}}
</div>

@stop