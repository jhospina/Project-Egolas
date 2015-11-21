<?php
use App\System\Models\Chapter;
use App\System\Library\Complements\Util;
$langs = App\System\Library\Enum\Language::getAll();
$qualities = Chapter::getQualities();
$subs = Chapter::getSubtitles();
?>
@extends("manager/ui/templates/main")

@section("title") Crear Manualmente @stop

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
                    <button type="button" onclick="submit('{{\App\System\Models\Production::STATE_IN_WAIT}}')" class="btn btn-default navbar-btn tooltip-bottom" title="{{trans("attr.production.state." . \App\System\Models\Production::STATE_IN_WAIT)}}"><span class="glyphicon glyphicon-hourglass"></span> Guardar</button>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </div>
</div>


<h1><span class="glyphicon glyphicon-facetime-video"></span> Crear nueva produccion</h1>



<form id="form" method="POST" action="">
    {{ csrf_field() }}
    <div class="col-lg-12">
        <div class="col-md-5">
            <div class="form-group">
                <label>{{trans("gen.info.title")}}</label>
                <input name="title" type="text" class="input-lg form-control" value=""> 
            </div>
            <div class="form-group">
                <label>{{trans("gen.info.description")}}</label>
                <textarea name="description" class="input-lg form-control" maxlength="525" style="height:133px;"></textarea>
            </div>
            <div class="form-group">
                <label>{{trans("gen.info.rating")}}</label>
                <input name="rating_rel" type="text" class="input-lg form-control" value=""> 
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>{{trans("gen.info.title.original")}}</label>
                <input name="title_original" type="text" class="input-lg form-control" value=""> 
            </div>
            <div class="form-group">
                <label>{{trans("gen.info.slug")}}</label>
                <input name="slug" type="text" class="input-lg form-control" value=""> 
            </div>
            <div class="form-group">
                <label>{{trans("gen.time.year")}}</label>
                <select name="year" type="text" class="input-lg form-control"> 
                    @for($i=date("Y")+5;$i>1969;$i--)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </div>
            <label>{{trans("gen.info.duration")}}</label>
            <div class="input-group">
                <input name="duration" type="text" class="input-lg form-control" value="" aria-describedby="basic-addon-min">
                <span class="input-group-addon" id="basic-addon-min">min</span> 
            </div>
        </div>
        <div class="col-md-2">
            <h3>{{trans("gen.info.categories")}}</h3>
            <div id="content-cats">
                @foreach($categories as $cat)
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="cat-{{$cat->id}}" value="{{$cat->id}}"> {{$cat->name}}
                    </label>
                </div>
                @endforeach
            </div>
        </div>   
    </div>
    <div class="col-sm-4">
        <label>URL de IMDB</label>
        <div class="form-group">
            <input type="text" class="form-control input-lg" name="imdb"/>
        </div>
    </div>

    <div class="col-sm-4">
        <label>URL de imagen de portada</label>
        <div class="form-group">
            <input type="text" class="form-control input-lg" name="image"/>
        </div>
    </div>
    <div class="col-sm-4">
        <label>URL de imagen de poster</label>
        <div class="form-group">
            <input type="text" class="form-control input-lg" name="poster"/>
        </div>
    </div>
</form>


@stop

@section("script")

<script>
            function submit(state){
            $("#state").val(state);
                    $("#form").submit();
            }
</script>

@stop