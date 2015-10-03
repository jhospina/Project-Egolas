<?php
use App\System\Library\Complements\Util;
use \App\System\Models\Dealer;
?>

@extends("ui/templates/gen")

@section("title"){{$production->title}}@stop

@section("css")
{{ HTML::style('assets/css/frontend/production/info.css', array('media' => 'screen')) }}
@stop

@section("content")


    <div id="play-production" class="container content">
        <div class="col-md-12" id="title">{{$production->title}} <span id="title-ori">({{$production->title_original}})</span></div>
        <div class="col-md-12">
            {{$frame_video}}
        </div>
    </div>
  



@stop