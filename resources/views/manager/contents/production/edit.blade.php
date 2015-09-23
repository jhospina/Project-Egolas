<?php

use App\System\Models\Dealer;
?>
@extends("manager/ui/templates/main")

@section("title") {{trans("gen.info.edit")}}: {{$production->title}}@stop

@section("content")


<div class="col-md-12">

    <div class="col-md-9">
        @include("ui/msg/index",array("message_id"=>2))
    </div>
    <div class="col-md-3">
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


<div class="col-lg-12">
    <h1><span class="glyphicon glyphicon-flag"></span> {{trans("ui.menu.item.contents.dealers")}} <a href="{{URL::to("manager/productions/".$production->id."/dealers")}}"><span class="glyphicon glyphicon-edit"></span></a></h1>

    <table class="table table-striped">
        <tr><th></th><th>{{trans("gen.info.name")}}</th>
        <th>{{trans("gen.info.quality")}}</th>
        <th>{{trans("gen.info.type")}}</th>
        <th>{{trans("gen.info.model")}}</th>
        <th>{{trans("gen.info.state")}}</th>
        <th></th>
        </tr>
        @foreach($dealers as $dealer)
        <tr>
            <td><img class="icon-dealer img-rounded" src="{{$dealer->image}}"></td>
            <td>{{$dealer->name}}</td>
            <td>{{trans("attr.pivot.production.dealer." . Dealer::PIVOT_PRODUCTION_ATTR_QUALITY . "." .$dealer->pivot->quality)}}</td>
            <td>{{trans("attr.dealer." . Dealer::ATTR_TYPE . "." .$dealer->type)}}</td>
            <td>{{trans("attr.dealer." . Dealer::ATTR_MODEL . "." .$dealer->model)}}</td>
            <td>{{trans("attr.pivot.production.dealer." . Dealer::PIVOT_PRODUCTION_ATTR_STATE . "." .$dealer->pivot->state)}}</td>
            <td><a target="_blank" href="{{$dealer->pivot->url}}">{{trans("gen.info.link")}}</a></td>
        </tr>


        @endforeach
    </table>
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