<?php

use App\System\Models\Dealer;
use App\System\Models\Production;

$langs = App\System\Library\Enum\Language::getAll();
$qualities = Dealer::getPivotProductionQualities();
$subs = Dealer::getPivotProductionSubtitles();
?>
@extends("manager/ui/templates/main")

@section("title"){{trans("ui.menu.item.contents.dealers")}} | {{$production->title}}@stop

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
                    <button type="button" onclick="postState('{{\App\System\Models\Production::STATE_ACTIVE}}')" class="btn btn-success navbar-btn tooltip-bottom" title="{{trans("attr.production.state." . \App\System\Models\Production::STATE_ACTIVE)}}"><span class="glyphicon glyphicon-ok-sign"> </span></button>
                    <button type="button" onclick="postState('{{\App\System\Models\Production::STATE_IN_WAIT}}')" class="btn btn-default navbar-btn tooltip-bottom" title="{{trans("attr.production.state." . \App\System\Models\Production::STATE_IN_WAIT)}}"><span class="glyphicon glyphicon-hourglass"></span></button>
                    <button type="button" onclick="postState('{{\App\System\Models\Production::STATE_COMING_SOON}}')" class="btn btn-warning navbar-btn tooltip-bottom" title="{{trans("attr.production.state." . \App\System\Models\Production::STATE_COMING_SOON)}}"><span class="glyphicon glyphicon-plane"></span></button>
                    <button type="button" onclick="postState('{{\App\System\Models\Production::STATE_IN_CINEMA}}')" class="btn btn-danger navbar-btn tooltip-bottom" title="{{trans("attr.production.state." . \App\System\Models\Production::STATE_IN_CINEMA)}}"><span class="glyphicon glyphicon-film"></span></button>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </div>
</div>


<div class="col-md-12">
    <h1><span class="glyphicon glyphicon-flag"></span> {{trans("ui.menu.item.contents.dealers")}} | <a href="{{URL::to("manager/productions/edit/".$production->id)}}">{{$production->title}}</a> <span id="state-production" class="label label-{{\App\System\Models\Production::getStyleColorState($production->state)}}">{{trans("attr.production.state." .$production->state)}}</span></h1>
    <div class="col-md-12" id="content-dealers" style="margin-top: 50px;">

        @foreach($dealers as $dealer)

        <?php
        $deal = $production->dealers()->find($dealer->id);
        $deal_langs = json_decode($deal["pivot"][Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES]);
        $deal_subs = json_decode($deal["pivot"][Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES]);
        ?>
        <div class="single-dealer">
            <div class="col-md-6" data-dealer="{{$dealer->id}}">
                <div class="panel panel-default dealer-production {{(is_null($deal))?:"active-deal"}}" id="dealer-form-{{$dealer->id}}">
                    <div class="panel-heading">
                        <div class="col-md-6">
                            <h4><span class="glyphicon glyphicon-flag"></span> {{$dealer->name}} <img class="icon-dealer img-rounded" src="{{$dealer->image}}"/></h4>
                        </div>
                        <div style="padding-top: 10px;" class="col-md-6 text-right">
                            <input type="checkbox" id="{{Dealer::PIVOT_PRODUCTION_ATTR_STATE}}-{{$dealer->id}}" data-id="{{$dealer->id}}" name="{{Dealer::PIVOT_PRODUCTION_ATTR_STATE}}" class="js-switch" {{($deal["pivot"][Dealer::PIVOT_PRODUCTION_ATTR_STATE]!=Dealer::PIVOT_PRODUCTION_STATE_AVAILABLE)?:"checked"}}> 
                            <button onClick="submit(this,{{$dealer->id}})" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-save"></span></button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>URL <a target="_blank" href="{{$dealer->url_search}}<?php echo urlencode($production->title) ?>"><span class="glyphicon glyphicon-globe"></span></a></label>
                            <input class="form-control input-lg" id="{{Dealer::PIVOT_PRODUCTION_ATTR_URL}}-{{$dealer->id}}" name="{{Dealer::PIVOT_PRODUCTION_ATTR_URL}}" type="text" value="{{(is_null($deal))?($dealer->name=="Bandicot")?URL::to("view/".$production->slug):"":$deal["pivot"][Dealer::PIVOT_PRODUCTION_ATTR_URL]}}"/>
                        </div>
                        <div class="col-md-3">
                            <label>{{trans("gen.info.languages")}}</label>
                            <div class="form-group">
                                @foreach($langs as $lang => $value)
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="{{Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES}}-{{$dealer->id}}" id="{{Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES}}-{{$lang}}-{{$dealer->id}}" name="{{Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES}}-{{$lang}}" value="{{$lang}}" {{(!is_array($deal_langs))?:(!in_array($lang,$deal_langs))?:"checked"}}/> {{$value}}
                                </label><br/>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>{{trans("gen.info.subtitles")}}</label>
                            <div class="form-group">
                                @foreach($subs as $sub => $value)
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="{{Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES}}-{{$dealer->id}}" id="{{Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES}}-{{$sub}}-{{$dealer->id}}" name="{{Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES}}-{{$sub}}" value="{{$sub}}" {{(!is_array($deal_subs))?:(!in_array($sub,$deal_subs))?:"checked"}}/> {{$value}}
                                </label><br/>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
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
        </div>

        @endforeach
    </div>
</div>



@stop

@section("script")


<script>

                                    function postState(state){

                                    var data = {"_token": "{{ Session::token() }}",
                                            "{{Production::ATTR_ID}}":"{{$production->id}}",
                                            "attr":"{{Production::ATTR_STATE}}",
                                            "value":state
                                    };
                                            $.ajax({
                                            url: "{{URL::to('manager/productions/ajax/post/edit/')}}",
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data:data,
                                                    success: function (response) {
                                                            $("#state-production").html("{{trans('gen.info.modifided')}}");
                                                            $("#state-production").removeAttr("class");
                                                            $("#state-production").attr("class","label label-warning");
                                                    }
                                            });
                                    }

</script>

<script>
                            $(document).ready(function(){

                            $(".switchery").remove();
                                    var dealers_active = new Array();
                                    var dealers_inactive = new Array();
                                    $(".single-dealer").each(function(){
                            if (/active-deal/.test($(this).html()))
                                    dealers_active.push($(this).html());
                                    else
                                    dealers_inactive.push($(this).html());
                            });
                                    $("#content-dealers").html("");
                                    for (var i = 0; i < dealers_active.length; i++){
                            $("#content-dealers").append(dealers_active[i]);
                            }

                            for (var i = 0; i < dealers_inactive.length; i++){
                            $("#content-dealers").append(dealers_inactive[i]);
                            }





                            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                                    elems.forEach(function (html) {
                                    var switchery = new Switchery(html, {secondaryColor: '#FF5656', className: "switchery switchery-small"});
                                    });
//CONTROL SWICTH

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
                            });
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
                                            var subs = new Array();
                                            $(".{{Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES}}-" + id).each(function(){
                                    if ($(this).is(':checked'))
                                            subs.push($(this).val());
                                    });
                                            var data = {"_token": "{{ Session::token() }}",
                                                    "{{Dealer::PIVOT_PRODUCTION_ATTR_PRODUCTION_ID}}": "{{$production->id}}",
                                                    "{{Dealer::PIVOT_PRODUCTION_ATTR_DEALER_ID}}":id,
                                                    "{{Dealer::PIVOT_PRODUCTION_ATTR_URL}}":url,
                                                    "{{Dealer::PIVOT_PRODUCTION_ATTR_LANGUAGES}}":langs,
                                                    "{{Dealer::PIVOT_PRODUCTION_ATTR_CONTENT}}":content,
                                                    "{{Dealer::PIVOT_PRODUCTION_ATTR_QUALITY}}":quality,
                                                    "{{Dealer::PIVOT_PRODUCTION_ATTR_SUBTITLES}}":subs
                                            };
                                            $.ajax({
                                            url: "{{URL::to('manager/productions/ajax/post/dealer')}}",
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data:data,
                                                    success: function (response) {
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