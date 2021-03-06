<?php

use \App\System\Models\Production;
use App\System\Library\Complements\Util;

$productions_id = array(); //Almacena los ids de las peliculas que se mostraran
?>
@extends("frontend/templates/gen",array("path"=>"frontend/contents/gen/browser","id_body"=>"browser"))


@section("title")Principal @stop

@section("css")
{{ HTML::style('assets/ui/slider/css/slider.css', array('media' => 'screen')) }}
<style>
    html,body{
        overflow-x: hidden;
    }
</style>
@stop

@section("content")

<h2>&nbsp;Agregado recientemente</h2>
<div class="content-slider-productions">
    <div class="slider-bcot" id="slider-recently">
        <section>
            @foreach($productions as $production)
            <div class="content-item">
                {{Production::getVisualHtml(Production::find($production->id),"item","production")}}
            </div>
            @endforeach
        </section>
    </div>
</div>

<div id="categories">
    <?php foreach ($categories as $category): ?>
        <?php
        $productions = $category->productions()
                        ->where(Production::ATTR_STATE, Production::STATE_ACTIVE)
                        ->orderBy(Production::ATTR_YEAR, "DESC")
                        ->whereNotIn("id", $productions_id)
                        ->groupBy("id")
                        ->take(20)->get();
        if (count($productions) < 10)
            continue;
        ?>
        <a href="{{URL::to("category/".$category->slug)}}"><h2 class="text-center title-category text-uppercase">{{ucfirst($category->mote)}}</h2></a>
        <div class="content-slider-productions">
            <div class="slider-bcot" id="slider-{{$category->id}}">
                <section>
                    @foreach($productions as $production)
                    <?php $productions_id[] = $production->id; ?>
                    <div class="content-item">
                        {{Production::getVisualHtml(Production::find($production->id),"item","production")}}
                    </div>
                <?php endforeach; ?>
            </section>
        </div>
    </div>
    @endforeach
</div>


@stop

@section("script")
{{ HTML::script('assets/ui/slider/scripts/slider.js') }}
@stop