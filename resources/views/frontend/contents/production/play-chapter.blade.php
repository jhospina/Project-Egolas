<?php

use App\System\Library\Complements\Util;
use \App\System\Models\Dealer;
?>

@extends("frontend/templates/gen")

@section("title"){{$production->title}}@stop

@section("css")
{{ HTML::style('assets/css/frontend/production/info.css', array('media' => 'screen')) }}
@stop

@section("content")



<div class="container content">
    <div class="col-md-12" id="title-play">{{$production->title}} <span id="title-ori">({{$production->title_original}})</span></div>
</div>
<div id="mask" class="col-md-12">
    <div id="play-production" class="container content">
        <div class="col-md-12">
            <div class="embed-responsive embed-responsive-16by9">
                <div id="spinner"></div>
                {{str_replace("<iframe ","<iframe id='video' class='embed-responsive-item' ",$video)}}
            </div>
        </div> 
    </div>
</div>

@stop

@section("script")
<script>

    $("#video").load(function () {
        $("#spinner").fadeOut(function(){
              $("#video").css("opacity", "1");
        });
    });

</script>

@stop