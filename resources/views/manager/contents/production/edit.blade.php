<?php

use App\System\Models\Chapter;

$langs = App\System\Library\Enum\Language::getAll();
$qualities = Chapter::getQualities();
$subs = Chapter::getSubtitles();
?>
@extends("manager/ui/templates/main")

@section("title") {{trans("gen.info.edit")}}: {{$production->title}}@stop

@section("content")


<div class="col-md-12">

    <div class="col-md-8">
        @include("ui/msg/index",array("message_id"=>2))
    </div>
    <div class="col-md-4">
        <nav class="navbar navbar-default">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-save"></span> {{trans("gen.info.as.save")}}:</a>
            </div>

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <button type="button" onclick="submit('{{\App\System\Models\Production::STATE_ACTIVE}}')" class="btn btn-success navbar-btn tooltip-bottom" title="{{trans("attr.production.state." . \App\System\Models\Production::STATE_ACTIVE)}}"><span class="glyphicon glyphicon-ok-sign"> </span></button>
                    <button type="button" onclick="submit('{{\App\System\Models\Production::STATE_IN_WAIT}}')" class="btn btn-default navbar-btn tooltip-bottom" title="{{trans("attr.production.state." . \App\System\Models\Production::STATE_IN_WAIT)}}"><span class="glyphicon glyphicon-hourglass"></span></button>
                    <button type="button" onclick="submit('{{\App\System\Models\Production::STATE_COMING_SOON}}')" class="btn btn-warning navbar-btn tooltip-bottom" title="{{trans("attr.production.state." . \App\System\Models\Production::STATE_COMING_SOON)}}"><span class="glyphicon glyphicon-plane"></span></button>
                    <button type="button" onclick="submit('{{\App\System\Models\Production::STATE_IN_CINEMA}}')" class="btn btn-danger navbar-btn tooltip-bottom" title="{{trans("attr.production.state." . \App\System\Models\Production::STATE_IN_CINEMA)}}"><span class="glyphicon glyphicon-film"></span></button>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </div>
</div>


<h1><span class="glyphicon glyphicon-facetime-video"></span> {{trans("gen.info.edit")}}: {{$production->title}} <span class="label label-{{\App\System\Models\Production::getStyleColorState($production->state)}}">{{trans("attr.production.state." .$production->state)}}</span></h1>



<form id="form" method="POST" action="">
    {{ csrf_field() }}
    <input type="hidden" id="state" name="state" value="{{$production->state}}"/>
    <input type="hidden"  name="id" value="{{$production->id}}"/>
    <div class="col-lg-12">
        <div class="col-md-5">
            <div class="form-group">
                <label>{{trans("gen.info.title")}}</label>
                <input name="title" type="text" class="input-lg form-control" value="{{$production->title}}"> 
            </div>
            <div class="form-group">
                <label>{{trans("gen.info.description")}}</label>
                <textarea name="description" class="input-lg form-control" style="height:133px;">{{$production->description}}</textarea>
            </div>
            <div class="form-group">
                <label>{{trans("gen.info.rating")}}</label>
                <input name="rating_rel" type="text" class="input-lg form-control" value="{{$production->rating_rel}}"> 
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>{{trans("gen.info.title.original")}}</label>
                <input name="title_original" type="text" class="input-lg form-control" value="{{$production->title_original}}"> 
            </div>
            <div class="form-group">
                <label>{{trans("gen.info.slug")}}</label>
                <input name="slug" type="text" class="input-lg form-control" value="{{$production->slug}}"> 
            </div>
            <div class="form-group">
                <label>{{trans("gen.time.year")}}</label>
                <select name="year" type="text" class="input-lg form-control"> 
                    @for($i=date("Y")+5;$i>1969;$i--)
                    <option value="{{$i}}" {{($i==$production->year)?"selected":""}}>{{$i}}</option>
                    @endfor
                </select>
            </div>
            <label>{{trans("gen.info.duration")}}</label>
            <div class="input-group">
                <input name="duration" type="text" class="input-lg form-control" value="{{$production->duration}}" aria-describedby="basic-addon-min">
                <span class="input-group-addon" id="basic-addon-min">min</span> 
            </div>
        </div>
        <div class="col-md-2">
            <h3>{{trans("gen.info.categories")}}</h3>
            <div id="content-cats">
                @foreach($categories as $cat)
                <div class="checkbox">
                    <label>
                        <input {{(in_array($cat->id,$cats_selected))?"checked='checked'":""}} type="checkbox" name="cat-{{$cat->id}}" value="{{$cat->id}}"> {{$cat->name}}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-2">
            <div id="image-mask">
                <img src="{{$production->image}}"/><br/>
                {{trans("gen.info.mask")}}
            </div>
        </div>
    </div>
</form>


<div class="col-lg-12" id="content-edit-production-video">
    <h2>Video</h2>
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="col-md-12">
                <label>{{trans("gen.info.name")}}</label>
                <input id="name-chapter"type="text" class="input-lg form-control" value=""> 
            </div>
            <div class="col-md-12">
                <label>{{trans("gen.info.content")}}</label>
                <textarea id="video-chapter" class="form-control"></textarea>
            </div>

        </div>
        <div class="col-md-6">
            <div class="col-md-12">
                <label>{{trans("gen.info.type")}}</label>
                <div class="form-group">
                    <label><input type="radio" id="type-chapter" name="type-chapter" value="{{Chapter::TYPE_MAIN}}" checked> {{trans("attr.chapter.type.".Chapter::TYPE_MAIN)}}</label> &nbsp;&nbsp;&nbsp;
                    <label> <input type="radio" id="type-chapter" name="type-chapter" value="{{Chapter::TYPE_EPISODE}}"> {{trans("attr.chapter.type.".Chapter::TYPE_EPISODE)}}</label>
                </div>
            </div>
            <div class="col-md-4">
                <label>{{trans("gen.info.languages")}}</label>
                <div class="form-group">
                    @foreach($langs as $lang => $value)
                    <label class="checkbox-inline">
                        <input type="checkbox" class="checkbox-circle" id="language-chapter-{{$lang}}"/> {{$value}}
                    </label><br/>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <label>{{trans("gen.info.subtitles")}}</label>
                <div class="form-group">
                    @foreach($subs as $sub => $value)
                    <label class="checkbox-inline">
                        <input type="checkbox" class="checkbox-circle" id="subtitle-chapter-{{$sub}}"/> {{$value}}
                    </label><br/>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <label>{{trans("gen.info.quality")}}</label>
                <div class="form-group">
                    @foreach($qualities as $quality => $value)

                    <div class="radio">
                        <label>
                            <input type="radio" id="quality-chapter-{{$quality}}" name="quality-chapter" value="{{$quality}}"> {{$value}}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@stop


@section("script")

<script>

                                    function submit(state){
                                    $("#state").val(state);
                                            $("#form").submit();
                                    }

</script>

@stop