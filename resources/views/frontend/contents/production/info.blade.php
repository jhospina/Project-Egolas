<?php
$rating=80;
$aux = ($rating >= 80) ? number_format(($rating / 100) * 255, 0) : 0;
?>

@extends("frontend/templates/gen",array("path"=>"frontend/contents/production/info"))

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


<div id="rating" class="container content">
    <h2><span class="glyphicon glyphicon-thumbs-up"></span> Nivel de satisfacción del público <small>({{$rating_count}} opiniones)</small></h2>
    <div id="content-bar">
        @for($i=1;$i<=5;$i++)
        <div class="line" style="left:{{($i*20)-0.2}}%">
            <img class="tooltip-bottom {{($rating>=$i*20 && $rating<($i+1)*20)?"":"inactive"}}" title="{{trans("attr.production.rating.".constant("App\System\Models\ProductionRating::RATING_".$i).".public")}}" src="{{URL::to("assets/images/ratings/".$i.".png")}}">
        </div>
        @endfor
        <div class="progress">
            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="{{$rating}}" aria-valuemin="0" aria-valuemax="100" style="background-color: rgb({{255-$aux}},{{number_format(($rating/100)*255,0)}},0);">
            </div>
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

<div id="comments" class="content container">
    <div class="title col-md-12"><h2>¿Qué te parecio esta película? Haz un comentario</h2></div>
    <div id="create-comment">
        <div class="col-xs-1 col-md-1" style="height: 110px;">
            <img class="avatar img-circle" src="{{(is_null(Auth::user()->avatar))?URL::to("assets/images/user_icon.png"):Auth::user()->avatar}}">
        </div>
        <div class="col-xs-11">
            <textarea class="form-control input-lg" id="content-comment" placeholder="Escribe un comentario aquí..."></textarea>
            <div class="col-mx-12 text-right">
                <input type="hidden" id="production-id" value="{{$production->id}}">
                <button type="button" id="submit-post-comment" class="btn btn-primary">Comentar</button>
            </div>
        </div>
    </div>
    <div class="title col-md-12"><h2><span class="glyphicon glyphicon-comment"></span> Comentarios</h2></div>
    <div id="list-comment"></div>
</div>

@stop

@section("script")
<script>
    var progress_rating="{{$rating}}%";
    var ajax_post_comment = "{{URL::to('ajax/comment/create')}}";
    var ajax_get_comments = "{{URL::to('ajax/comment/get')}}";
    var token = "{{ Session::token() }}";
    var name_user = "{{Auth::user()->name}}";
</script>
@stop