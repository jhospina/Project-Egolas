<?php

use \App\System\Models\Dealer;

$types = Dealer::getTypes();
$models = Dealer::getModels();
?>

@extends("manager/ui/templates/main")

@section("title"){{trans("ui.menu.item.contents.dealers")}}@stop

@section("content")


<div class="col-md-12">
    <h1><span class="glyphicon glyphicon-flag"></span> {{trans("ui.menu.item.contents.dealers")}}: {{trans("ui.btn.add")}}</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="{{Dealer::ATTR_ID}}" value="{{$id}}"/>
        <div class="col-md-12" style="margin-top: 20px;">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{trans("gen.info.name")}}</label>
                    <input class="form-control input-lg" type="text" name="{{Dealer::ATTR_NAME}}" value="{{(isset($dealer->name))?$dealer->name:null}}">
                </div>
                <div class="form-group">
                    <label>{{trans("gen.info.website")}}</label>
                    <input class="form-control input-lg" type="text" name="{{Dealer::ATTR_WEBSITE}}" value="{{(isset($dealer->website))?$dealer->website:null}}">
                </div>
                <div class="form-group">
                    <label>{{trans("gen.info.url.search")}}</label>
                    <input class="form-control input-lg" type="text" name="{{Dealer::ATTR_URL_SEARCH}}" value="{{(isset($dealer->url_search))?$dealer->url_search:null}}">
                </div>
                <div class="form-group">
                    <label>{{trans("gen.info.type")}}</label>
                    <select class="form-control input-lg" name="{{Dealer::ATTR_TYPE}}">
                        @foreach($types as $type)
                        <option value="{{$type}}" @if(isset($dealer->type) && $dealer->type==$type){{"selected"}}@endif>{{trans("attr.dealer.".Dealer::ATTR_TYPE.".".$type)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>{{trans("gen.info.model")}}</label>
                    <select class="form-control input-lg" name="{{Dealer::ATTR_MODEL}}">
                        @foreach($models as $model)
                        <option value="{{$model}}"@if(isset($dealer->model) && $dealer->model==$model){{"selected"}}@endif>{{trans("attr.dealer.".Dealer::ATTR_MODEL.".".$model)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>{{trans("gen.info.icon")}}</label>
                    @if(isset($dealer->image))
                    <div class="text-center" style="margin-bottom:10px;">
                        <img style="max-width: 200px;" src="{{$dealer->image}}">
                    </div>
                    @endif
                    <input class="filestyle" type="file" name="{{Dealer::ATTR_IMAGE}}" accept="image/*" data-buttonText="{{trans("ui.btn.select.file")}}">
                </div>
            </div>     
        </div>
        <div class="col-md-4 text-center" style="margin-top: 20px;">
            <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-save"></span>{{trans("ui.btn.save")}}</button>
        </div>
    </form>

</div>

@stop

@section("script")
{{ HTML::script('assets/js/bootstrap-filestyle.min.js') }}
@stop