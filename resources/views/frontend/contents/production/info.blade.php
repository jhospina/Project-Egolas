<?php
$aux = ($rating >= 80) ? number_format(($rating / 100) * 255, 0) : 0;
?>

@extends("frontend/templates/gen",array("path"=>"frontend/contents/production/info"))

@section("title"){{$production->title}}@stop

@section("css")
{{ HTML::style('assets/css/frontend/production/info.css', array('media' => 'screen')) }}
{{ HTML::style('assets/css/frontend/production/info-mobile.css', array('media' => 'screen')) }}
@stop

@section("content")

<h1 id="title-production-mob" class="text-center">{{$production->title}}<br/><small>{{$production->title_original}}</small></h1>
<div id="info" class="content container">
    <div id="title-production" class="col-md-10">{{$production->title}} <span id="title-ori">({{$production->title_original}})</span></div>
    <div class="col-md-2 text-right" style="padding: 0px;">
        <div id="rating-imdb">
            {{$production->rating_rel}}
            <div id="tag-imdb">IMDB</div>
        </div>
    </div>
    <div class="col-md-3" id="image-content">
        <div id="poster">
            <img class="img-rounded" src="{{$production->image}}">
            @if(!$inFav)
            <div id="content-add-favorite">
                <span class="glyphicon glyphicon-star-empty"></span>
                <label>Agregar a mi lista de favoritos</label>
            </div>
            @else
            <div id="inFav" title="En favoritos"><span class="glyphicon glyphicon-star"></span></div>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <b>{{trans("gen.info.synopsis")}}</b><br/>
        <p class="text-justify">{{$production->description}}</p>
        <div id="details">
            @if($isVideoMain)
            <div class="col-xs-4 attr"><span class="glyphicon glyphicon-calendar"></span> {{trans("gen.time.year")}}</div><div class="col-xs-8 value">{{$production->year}}</div>
            <div class="col-xs-4 attr"><span class="glyphicon glyphicon-time"></span> {{trans("gen.info.duration")}}</div><div class="col-xs-8 value">{{$production->duration}} min</div>
            <?php $video = $chapters[0]; ?> 
            <div class="col-xs-4 attr"><span class="glyphicon glyphicon-hd-video"></span> {{trans("gen.info.quality")}}</div><div class="col-xs-8 value">{{trans("attr.chapter.quality.".$video->quality)}}</div>
            <div class="col-xs-4 attr"><span class="glyphicon glyphicon-sound-dolby"></span> {{trans("gen.info.language")}}</div><div class="col-xs-8 value">{{trans("attr.language.".$video->languages[0])}}</div>
            @if(count($video->subtitles)>0)
            <div class="col-xs-4 attr"><span class="glyphicon glyphicon-subtitles"></span> {{trans("gen.info.subtitles")}}</div><div class="col-xs-8 value">{{trans("attr.chapter.subtitles.".$video->subtitles[0])}}</div>
            @endif
            <div class="col-md-12 attr" style="margin-top:20px;">{{trans("gen.info.categories")}}</div>
            <div class="col-md-12 value">{{Util::formatResultObjects($categories, \App\System\Models\Term::ATTR_NAME,", ")}}</div>
            @endif
        </div>
        @if($isVideoMain)
        <div class="col-md-12 value text-center">
            <a id="ver-online" href="{{URL::to("production/".$production->slug."/play")}}"><span class="glyphicon glyphicon-play-circle"></span> Reproducir</a>
        </div>
        @endif

    </div>
    <div class="col-md-4">
        <div class="col-md-12"><b>{{trans("gen.info.director")}}</b></div>
        <div class="col-md-12">
            @if(!is_null($director->image))<a href="{{URL::to("person/".$director->slug)}}" class="staff"> @endif
                @if(!is_null($director->image)) <div class="avatar">
                    <img class="img-circle" src="{{$director->image}}"/>
                </div>
                @endif
                <div class="person">{{$director->name}}</div>
                @if(!is_null($director->image))</a>@endif
        </div>
        <div class="col-md-12"><b>{{trans("gen.info.delivery")}}</b></div>
        <div class="col-md-12" id="staff-content">
            @foreach($staff as $person)
            @if(!is_null($person->image))
            <a href="{{URL::to("person/".$person->slug)}}" class="staff">
                @endif
                @if(!is_null($person->image))
                <div class="avatar">
                    <img class="img-circle" src="{{$person->image}}"/>
                </div>
                @endif
                <div class="person">{{$person->name}}</div>
                @if(!is_null($person->image))  </a> @endif
            @endforeach
        </div>
    </div>
</div>


<div id="rating" class="container content">
    @if(!$userIsRated)
    <div id="open-modal-rating-new" class="btn btn-success"><span class="glyphicon glyphicon-heart"></span> Dar mi opinión</div>
    @endif
    <h2><span class="glyphicon glyphicon-thumbs-up"></span> Nivel de satisfacción del público <small>({{$rating_count}} {{($rating_count>1)?"opiniones":"opinión"}})</small></h2>
    <div id="content-bar">
        @for($i=1;$i<=5;$i++)
        <div class="line" style="left:{{($i*20)-0.2}}%">
            <img class="tooltip-bottom {{($rating>=$i*20 && $rating<($i+1)*20)?"":"inactive"}}" title="{{trans("attr.production.rating.".constant("App\System\Models\Production\ProductionRating::RATING_".$i).".public")}}" src="{{URL::to("assets/images/ratings/".$i.".png")}}">
        </div>
        @endfor
        <div class="progress">
            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="{{$rating}}" aria-valuemin="0" aria-valuemax="100" style="background-color: rgb({{255-$aux}},{{number_format(($rating/100)*255,0)}},0);">
            </div>
        </div>
    </div>
</div>


<!-- Modal Rating -->
<!-- Modal -->
<div class="modal fade" id="modal-rating" tabindex="-1" role="dialog" aria-labelledby="modal-rating">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title text-center">¿Cuál fue tu nivel de satifacción con esta producción?</h2>
            </div>
            <div class="modal-body">
                <div id="content-bar-rating">
                    @for($i=1;$i<=5;$i++)
                    <div class="line" style="bottom:{{($i*20)-0.2}}%" data-rating="{{$i}}">
                        <img class="inactive" src="{{URL::to("assets/images/ratings/".$i.".png")}}">
                        <div class="rating-description">{{trans("attr.production.rating.".constant("App\System\Models\Production\ProductionRating::RATING_".$i))}}</div>
                    </div>
                    @endfor
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$rating}}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary disabled" id="send-rating" disabled>Enviar</button>
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
    <div class="clearfix"></div>
    <div class="title col-md-12" style="margin-top:50px;"><h2><span class="glyphicon glyphicon-comment"></span> Comentarios</h2></div>
    <div id="list-comment"></div>
</div>

@stop

@section("script")
<script>
    var progress_rating = "{{$rating}}%";
    var ajax_post_comment = "{{URL::to('ajax/comment/create')}}";
    var ajax_post_rating = "{{URL::to('ajax/production/rating/post')}}";
    var ajax_get_comments = "{{URL::to('ajax/comment/get')}}";
    var token = "{{ Session::token() }}";
    var name_user = "{{Auth::user()->name}}";
    var ajax_post_favorites = "{{URL::to('ajax/user/favorites/add/production')}}";
</script>
@stop