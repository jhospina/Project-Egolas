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

        <?php
        $deal = $production->dealers()->find($dealer->id);
        $deal_langs = json_decode($deal["pivot"][Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES]);
        ?>

        <div class="col-md-6">
            <div class="panel panel-default dealer-production {{(is_null($deal))?:"active-deal"}}" id="dealer-form-{{$dealer->id}}">
                <div class="panel-heading">
                    <div class="col-md-6">
                        <h4><span class="glyphicon glyphicon-flag"></span> {{$dealer->name}} <img class="icon-dealer img-rounded" src="{{$dealer->image}}"/></h4>
                    </div>
                    <div style="padding-top: 10px;" class="col-md-6 text-right">
                        <input type="checkbox" id="{{Dealer::PIVOT_PRODUCTION_ATTR_STATE}}-{{$dealer->id}}" data-id="{{$dealer->id}}" name="{{Dealer::PIVOT_PRODUCTION_ATTR_STATE}}" class="js-switch" {{(is_null($deal))?"":($deal["pivot"][Dealer::PIVOT_PRODUCTION_ATTR_STATE]!=Dealer::PIVOT_PRODUCTION_STATE_AVAILABLE)?:"checked"}}> 
                        <button onClick="submit(this,{{$dealer->id}})" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-save"></span></button>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>URL</label>
                        <input class="form-control input-lg" id="{{Dealer::PIVOT_PRODUCTION_ATTR_URL}}-{{$dealer->id}}" name="{{Dealer::PIVOT_PRODUCTION_ATTR_URL}}" type="text" value="{{(is_null($deal))?"":$deal["pivot"][Dealer::PIVOT_PRODUCTION_ATTR_URL]}}"/>
                    </div>
                    <div class="col-md-4">
                        <label>{{trans("gen.info.languages")}}</label>
                        <div class="form-group">
                            @foreach($langs as $lang => $value)
                            <label class="checkbox-inline">
                                <input type="checkbox" class="{{Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES}}-{{$dealer->id}}" id="{{Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES}}-{{$lang}}-{{$dealer->id}}" name="{{Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES}}-{{$lang}}" value="{{$lang}}" {{(!is_array($deal_langs))?:(!in_array($lang,$deal_langs))?:"checked"}}/> {{$value}}
                            </label><br/>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>{{trans("gen.info.content")}}</label>
                        <textarea class="form-control input-lg" id="{{Dealer::PIVOT_PRODUCTION_ATTR_CONTENT}}-{{$dealer->id}}" name="{{Dealer::PIVOT_PRODUCTION_ATTR_CONTENT}}">{{(is_null($deal)?"":$deal["pivot"][Dealer::PIVOT_PRODUCTION_ATTR_CONTENT])}}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label>{{trans("gen.info.quality")}}</label>
                        <div class="form-group">
                            @foreach($qualities as $quality => $value)
                            <div class="radio">
                                <label>
                                    <input type="radio" id="{{Dealer::PIVOT_PRODUCTION_ATTR_QUALITY}}-{{$quality}}-{{$dealer->id}}" name="{{Dealer::PIVOT_PRODUCTION_ATTR_QUALITY}}-{{$dealer->id}}" value="{{$quality}}" {{(is_null($deal))?:($deal["pivot"][Dealer::PIVOT_PRODUCTION_ATTR_QUALITY]==$quality)?"checked":""}}> {{$value}}
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
            jQuery(".js-switch").change(function () {

    var state = null;
            var id = $(this).attr("data-id");
            if ($(this).is(':checked'))
            state = "{{Dealer::PIVOT_PRODUCTION_STATE_AVAILABLE}}";
            else
            state = "{{Dealer::PIVOT_PRODUCTION_STATE_OFFLINE}}";
            $.ajax({
            url: "{{URL::to('manager/productions/ajax/post/edit/pivot/dealer/state')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: {"_token": "{{ Session::token() }}",
                            "{{Dealer::PIVOT_PRODUCTION_ATTR_PRODUCTION_ID}}": "{{$production->id}}",
                            "{{Dealer::PIVOT_PRODUCTION_ATTR_DEALER_ID}}":id,
                            "{{Dealer::PIVOT_PRODUCTION_ATTR_STATE}}":state
                    }});
    });</script>

<script>

            function submit(btn, id){

            $(btn).html("...");
                    $(btn).attr("disabled", "disabled");
                    var url = $("#{{Dealer::PIVOT_PRODUCTION_ATTR_URL}}-" + id).val();
                    var content = $("#{{Dealer::PIVOT_PRODUCTION_ATTR_CONTENT}}-" + id).val();
                    var quality = $('input[name={{Dealer::PIVOT_PRODUCTION_ATTR_QUALITY}}-' + id + ']:radio:checked').val();
                    var langs = new Array();
                    $(".{{Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES}}-" + id).each(function(){
            if ($(this).is(':checked'))
                    langs.push($(this).val());
            });
                    $.ajax({
                    url: "{{URL::to('manager/productions/ajax/post/dealer')}}",
                            type: 'POST',
                            dataType: 'json',
                            data: {"_token": "{{ Session::token() }}",
                                    "{{Dealer::PIVOT_PRODUCTION_ATTR_PRODUCTION_ID}}": "{{$production->id}}",
                                    "{{Dealer::PIVOT_PRODUCTION_ATTR_DEALER_ID}}":id,
                                    "{{Dealer::PIVOT_PRODUCTION_ATTR_URL}}":url,
                                    "{{Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES}}":langs,
                                    "{{Dealer::PIVOT_PRODUCTION_ATTR_CONTENT}}":content,
                                    "{{Dealer::PIVOT_PRODUCTION_ATTR_QUALITY}}":quality
                            },
                            success: function (response) {
                            console.log(response);
                                    $("#dealer-form-" + id).addClass("active-deal");
                                    $(btn).removeClass("btn-primary");
                                    $(btn).addClass("btn-success");
                                    $(btn).html("<span class='glyphicon glyphicon-ok'></span>");
                                    setTimeout(function(){
                                    $(btn).removeAttr("disabled")
                                            $(btn).removeClass("btn-success");
                                            $(btn).addClass("btn-primary");
                                            $(btn).html("<span class='glyphicon glyphicon-save'></span>");
                                    }, 2000);
                            }
                    });
            }

</script>

@stop