<?php

use App\System\Models\Production;
use App\System\Library\Complements\DateUtil;
?>
@extends("user/templates/gen",array("title"=>"<span class='glyphicon glyphicon-dashboard'></span> Dashboard"))

@section("content")

<h2>Últimas reproducciones</h2>

<div id="last-playbacks">
    @if(count($plays)>0)
    <section style="width:{{count($plays)*154}}px;">
        @foreach($plays as $play)
        <a href="{{URL::to('production/'.$play->slug)}}"><img width="150px" height="224px" src="{{$play->image}}"/></a>
        @endforeach
    </section>
    @else
    <div class="col-lg-12 without-info" style="padding: 40px;">
        <span class="glyphicon glyphicon glyphicon-send"></span><br>
        <div>Aún no tienes reproducciones </br><a href="{{URL::to("")}}">Clic aquí para ver el catalogo producciones</a></div>
    </div>
    @endif
</div>

<div id="activity-dashboard" style="margin-top:50px;">
    <h2>Mi actividad</h2>
    <div class="col-sm-6" style="padding: 0px;">
        <div class="panel panel-bandicot">
            <div class="panel-heading"><h3 style="margin:0px;"><span class="glyphicon glyphicon-heart"></span> Puntuaciones de satifacción</h3></div>
            <div class="panel-body">
                @if(count($ratings)>0)
                <ul class="list-group">
                    @foreach($ratings as $rating)
                    <?php
                    $production = Production::findOrNew($rating->production_id);
                    ?>
                    <li class="list-group-item">
                        <span class="badge" style="font-weight: 100;">Hace {{DateUtil::calculateDifference($rating->date)}}</span>
                        Puntuaste <img class="tooltip-top" title="{{trans("attr.production.rating.rating_".$rating->rating)}}" width="20px" src="{{URL::to("assets/images/ratings/".$rating->rating.".png")}}"> a <a target="_blank" href="{{URL::to("production/".$production->slug)}}">{{$production->title}}</a>.
                    </li>
                    @endforeach
                </ul>
                @if(count($ratings)==6)
                <div class="text-center">
                    <a class="btn btn-primary" href="{{URL::to("user/activity/ratings")}}"><span class="glyphicon glyphicon-time"></span> Ver todos las puntuaciones realizadas</a>
                </div>
                @endif
                @else
                <div class="col-lg-12 without-info" style="padding: 40px;">
                    <span class="glyphicon glyphicon glyphicon-send"></span><br>
                    <div>Aún no haz realizado ninguna puntuación</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-bandicot" style="padding: 0px;">
            <div class="panel-heading"><h3 style="margin:0px;"><span class="glyphicon glyphicon-comment"></span> Comentarios</h3></div>
            <div class="panel-body">
                <ul class="list-group">
                    @if(count($comments)>0)
                    @foreach($comments as $comment)
                    <?php
                    $production = Production::findOrNew($comment->production_id);
                    ?>
                    <li class="list-group-item">
                        <span class="badge" style="font-weight: 100;">Hace {{DateUtil::calculateDifference($comment->created_at)}}</span>
                        Realizaste un comentario en <a target="_blank" href="{{URL::to("production/".$production->slug)}}">{{$production->title}}</a>.
                    </li>
                    @endforeach
                </ul>
                @if(count($comments)==6)
                <div class="text-center">
                    <a class="btn btn-primary" href="{{URL::to("user/activity/comments")}}"><span class="glyphicon glyphicon-time"></span> Ver todos los comentarios realizados</a>
                </div>
                @endif
                @else
                <div class="col-lg-12 without-info" style="padding: 40px;">
                    <span class="glyphicon glyphicon glyphicon-send"></span><br>
                    <div>Aún no haz realizado ningún comentario</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@stop