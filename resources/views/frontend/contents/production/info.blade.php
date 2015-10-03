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
        <div class="col-md-3 attr"><span class="glyphicon glyphicon-calendar"></span> {{trans("gen.time.year")}}</div><div class="col-md-9 value">{{$production->year}}</div>
        <div class="col-md-3 attr"><span class="glyphicon glyphicon-time"></span> {{trans("gen.info.duration")}}</div><div class="col-md-9 value">{{$production->duration}} min</div>
        <div class="col-md-12 attr" style="margin-top:20px;">{{trans("gen.info.categories")}}</div>
        <div class="col-md-12 value">{{Util::formatResultObjects($categories, \App\System\Models\Term::ATTR_NAME,", ")}}</div>
        <div class="col-md-12 value text-center">
            <a id="ver-online" href="{{URL::to("f/production/".$production->slug."/play")}}"><span class="glyphicon glyphicon-play-circle"></span> Ver online</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="col-md-12"><b>{{trans("gen.info.director")}}</b></div>
        <div class="col-md-12">
            <a href="{{URL::to("f/person/".$director->slug)}}" class="staff">
                <div class="avatar">
                    <img class="img-circle" src="{{$director->image}}"/>
                </div>
                <div class="person">{{$director->name}}</div>
            </a>
        </div>
        <div class="col-md-12"><b>{{trans("gen.info.delivery")}}</b></div>
        <div class="col-md-12" id="staff-content">
            @foreach($staff as $person)
            <a href="{{URL::to("f/person/".$person->slug)}}" class="staff">
                <div class="avatar">
                    <img class="img-circle" src="{{$person->image}}"/>
                </div>
                <div class="person">{{$person->name}}</div>
            </a>
            @endforeach
        </div>
    </div>
</div>

<div id="dealers" class="content container">
    <div class="col-md-12 text-center"><h3>{{trans("gen.info.availability")}}</h3></div>
    <div class="col-md-12">
        <?php foreach ($dealers as $dealer): ?>
            <?php
            $languages = array();
            foreach (json_decode($dealer->pivot->languages) as $index => $value):
                $languages[] = trans("attr.language." . $value);
            endforeach;
            $subtitles = array();
            if (!is_null($dealer->pivot->subtitles)) {
                foreach (json_decode($dealer->pivot->subtitles) as $index => $value):
                    $subtitles[] = trans("attr.pivot.production.dealer." . Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES . "." . $value);
                endforeach;
                if ($dealer->name == Dealer::OWN)
                    continue;
            }
            ?>
            <div class="dealer col-md-4">
                <div class="model {{$dealer->model}}">{{trans("attr.dealer." . Dealer::ATTR_MODEL . "." . $dealer->model)}}</div>
                <div class="img-dealer">
                    <img class="img-circle" src="{{$dealer->image}}">
                </div>
                <div class="details col-md-12">
                    <div class="col-md-4"><span class="glyphicon glyphicon-certificate"></span> {{trans("gen.info.quality")}}</div>
                    <div class="col-md-8">{{trans("attr.pivot.production.dealer.".Dealer::PIVOT_PRODUCTION_ATTR_QUALITY.".".$dealer->pivot->quality)}}</div>
                    <div class="col-md-4"><span class="glyphicon glyphicon-globe"></span> {{trans("gen.info.language")}}</div>
                    <div class="col-md-8">
                        {{Util::formatResultArray($languages,", ")}}
                    </div>
                    <div class="col-md-4"><span class="glyphicon glyphicon-subtitles"></span> {{trans("gen.info.subtitles")}}</div>
                    <div class="col-md-8">
                        @if(count($subtitles)>0)
                        {{Util::formatResultArray($subtitles,", ")}}
                        @else
                        {{trans("gen.info.none")}}
                        @endif
                    </div>
                </div>
                <a target="_blank" href="{{$dealer->pivot->url}}" class="tag-type"><span class="{{trans("attr.dealer." . Dealer::ATTR_TYPE . ".".$dealer->type.".icon")}}"></span> {{trans("attr.dealer." . Dealer::ATTR_TYPE . ".".$dealer->type)}}</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>


@stop