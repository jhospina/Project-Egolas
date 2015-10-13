<?php

use App\System\Library\Complements\Util;
?>

@extends("frontend/templates/gen")

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
        @if($isVideoMain)
        <div class="col-md-4 attr"><span class="glyphicon glyphicon-calendar"></span> {{trans("gen.time.year")}}</div><div class="col-md-8 value">{{$production->year}}</div>
        <div class="col-md-4 attr"><span class="glyphicon glyphicon-time"></span> {{trans("gen.info.duration")}}</div><div class="col-md-8 value">{{$production->duration}} min</div>
        <?php $video = $chapters[0]; ?> 
        <div class="col-md-4 attr"><span class="glyphicon glyphicon-hd-video"></span> {{trans("gen.info.quality")}}</div><div class="col-md-8 value">{{trans("attr.chapter.quality.".$video->quality)}}</div>
        <div class="col-md-4 attr"><span class="glyphicon glyphicon-sound-dolby"></span> {{trans("gen.info.language")}}</div><div class="col-md-8 value">{{trans("attr.language.".$video->languages[0])}}</div>
        @if(count($video->subtitles)>0)
        <div class="col-md-4 attr"><span class="glyphicon glyphicon-subtitles"></span> {{trans("gen.info.subtitles")}}</div><div class="col-md-8 value">{{trans("attr.chapter.subtitles.".$video->subtitles[0])}}</div>
        @endif
        <div class="col-md-12 attr" style="margin-top:20px;">{{trans("gen.info.categories")}}</div>
        <div class="col-md-12 value">{{Util::formatResultObjects($categories, \App\System\Models\Term::ATTR_NAME,", ")}}</div>
        @endif
        @if($isVideoMain)
        <div class="col-md-12 value text-center">
            <a id="ver-online" href="{{URL::to("production/".$production->slug."/play")}}"><span class="glyphicon glyphicon-play-circle"></span> Ver online</a>
        </div>
        @endif
    </div>
    <div class="col-md-4">
        <div class="col-md-12"><b>{{trans("gen.info.director")}}</b></div>
        <div class="col-md-12">
            <a href="{{URL::to("person/".$director->slug)}}" class="staff">
                <div class="avatar">
                    <img class="img-circle" src="{{$director->image}}"/>
                </div>
                <div class="person">{{$director->name}}</div>
            </a>
        </div>
        <div class="col-md-12"><b>{{trans("gen.info.delivery")}}</b></div>
        <div class="col-md-12" id="staff-content">
            @foreach($staff as $person)
            <a href="{{URL::to("person/".$person->slug)}}" class="staff">
                <div class="avatar">
                    <img class="img-circle" src="{{$person->image}}"/>
                </div>
                <div class="person">{{$person->name}}</div>
            </a>
            @endforeach
        </div>
    </div>
</div>

@if(!$isVideoMain && count($chapters)>1)
<div id="chapters" class="content container">

    <div class="title col-md-12">{{trans("gen.info.episodes")}}</div>

    <div id="display-chapters" class="col-md-12">
        @foreach($chapters as $chapter)
        <a class="chapter col-md-12" href="{{URL::to("f/production/".$production->slug."/play/".$chapter->id."/".Util::createSlug($chapter->name))}}">
            <div class="col-md-8">{{$chapter->name}}</div>
            <div class="col-md-4 text-right"><span class="glyphicon glyphicon-play-circle"></span></div>
        </a>    
        @endforeach
    </div>

</div>
@endif

@stop