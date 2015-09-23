<?php

use App\System\Library\Complements\Util;
?>

@extends("ui/templates/gen")

@section("title"){{$production->title}}@stop

@section("css")
{{ HTML::style('assets/css/frontend/production/info.css', array('media' => 'screen')) }}
@stop

@section("content")

<div id="info" class="content container">
    <div id="title-production" class="col-md-10">{{$production->title}} <span id="title-ori">({{$production->title_original}})</span></div>
    <div class="col-md-2 text-right" style="padding: 0px;">
        <div id="rating-imdb">
            {{$production->rating_rel}}
            <div id="tag-imdb">IMDB</div>
        </div>
    </div>
    <div class="col-md-3" id="image-content">
        <img class="img-rounded" src="{{$production->image}}">
    </div>
    <div class="col-md-4">
        <b>{{trans("gen.info.synopsis")}}</b><br/>
        <p class="text-justify">{{$production->description}}</p>
        <div class="col-md-3 attr">{{trans("gen.time.year")}}</div><div class="col-md-9 value">{{$production->year}}</div>
        <div class="col-md-3 attr">{{trans("gen.info.duration")}}</div><div class="col-md-9 value">{{$production->duration}} min</div>
        <div class="col-md-12 attr" style="margin-top:20px;">{{trans("gen.info.categories")}}</div>
        <div class="col-md-12 value">{{Util::formatResultObjects($categories, \App\System\Models\Term::ATTR_NAME,", ")}}</div>
    </div>
    <div class="col-md-4">
        <div class="col-md-12"><b>{{trans("gen.info.director")}}</b></div>
        <div class="col-md-12">
            <div class="staff">
                {{$director->name}}
            </div>
        </div>
        <div class="col-md-12"><b>{{trans("gen.info.delivery")}}</b></div>
        <div class="col-md-12" id="staff-content">
            @foreach($staff as $person)
            <div class="staff">
                {{$person->name}}
            </div>
            @endforeach
        </div>
    </div>
</div>

@stop