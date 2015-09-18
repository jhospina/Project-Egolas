<?php

use App\System\Models\Dealer;

$langs = App\System\Library\Enum\Language::getAll();
$qualities = Dealer::getPivotProductionQualities();
?>
@extends("manager/ui/templates/main")

@section("title"){{trans("ui.menu.item.contents.dealers")}} | {{$production->title}}@stop

@section("content")


<div class="col-md-12">
    <h1><span class="glyphicon glyphicon-flag"></span> {{trans("ui.menu.item.contents.dealers")}} | {{$production->title}}</h1>
    <div class="col-md-12">

        @foreach($dealers as $dealer)

        <div class="col-md-6">
            <div class="panel panel-default dealer-production" id="dealer-form-{{$dealer->id}}">
                <div class="panel-heading">
                    <div class="col-md-6">
                        <h4><span class="glyphicon glyphicon-flag"></span> {{$dealer->name}} <img class="icon-dealer img-rounded" src="{{$dealer->image}}"/></h4>
                    </div>
                    <div style="padding-top: 10px;" class="col-md-6 text-right">
                        <input type="checkbox" name="{{Dealer::PIVOT_PRODUCTION_ATTR_STATE}}" class="js-switch">
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>URL</label>
                        <input class="form-control input-lg" name="{{Dealer::PIVOT_PRODUCTION_ATTR_URL}}" type="text"/>
                    </div>
                    <div class="col-md-4">
                        <label>{{trans("gen.info.languages")}}</label>
                        <div class="form-group">
                            @foreach($langs as $lang => $value)
                            <label class="checkbox-inline">
                                <input type="checkbox" name="{{Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES}}-{{$lang}}"/> {{$value}}
                            </label><br/>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>{{trans("gen.info.content")}}</label>
                        <textarea class="form-control input-lg" name="{{Dealer::PIVOT_PRODUCTION_ATTR_CONTENT}}"></textarea>
                    </div>
                    <div class="col-md-4">
                        <label>{{trans("gen.info.quality")}}</label>
                        <div class="form-group">
                            @foreach($qualities as $quality => $value)
                            <div class="radio">
                                <label>
                                    <input type="radio" name="{{Dealer::PIVOT_PRODUCTION_ATTR_QUALITY}}"> {{$value}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div>
</div>



@stop

@section("script")

<script>



</script>

@stop