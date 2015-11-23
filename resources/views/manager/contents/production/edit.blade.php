<?php

use App\System\Models\Chapter;
use App\System\Library\Complements\Util;
use App\System\Models\VideoCloudAccount;

$langs = App\System\Library\Enum\Language::getAll();
$qualities = Chapter::getQualities();
$subs = Chapter::getSubtitles();

$chapters = $production->chapters;
$isVideoMain = $production->haveVideoMain();



if ($isVideoMain)
    $chapter = $chapters[0];

$videocloud = (!isset($chapter)) ? VideoCloudAccount::getCurrentAccountEmail() : VideoCloudAccount::getAccountEmailById($chapter->videocloud_id);
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
                <textarea name="description" class="input-lg form-control" maxlength="525" style="height:133px;">{{$production->description}}</textarea>
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
                <a target="_blank" href="{{URL::to('production/'.$production->slug)}}">
                    <img src="{{$production->image}}"/><br/>
                </a>
                {{trans("gen.info.mask")}}
            </div>
        </div>
    </div>
</form>


<div class="col-lg-12" id="content-edit-production-video">
    <h2>Video</h2>
    <div class="col-md-12" id="form-add-video" style='{{(count($chapters)>0 && !$isVideoMain)?'display:none;':null}}'>
        <button id="btn-guardar-shapter" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> {{trans("gen.info.save")}}</button>
        <input type="hidden" id="id-chapter" value="{{(isset($chapter))?$chapter->id:null}}"> 

        <div class="col-md-6">
            <div class="col-md-12">
                <label>{{trans("gen.info.name")}}</label>
                <input id="name-chapter"type="text" class="input-lg form-control" value="{{(isset($chapter))?$chapter->name:null}}"> 
            </div>
            <div class="col-md-12">
                <label>ID Video</label>
                <input id="video-chapter" class="form-control" value='{{(isset($chapter))?$chapter->video:null}}'>
            </div>
            <div class="col-md-12">
                <label>Cuenta Videocloud</label>
                <input readonly="readonly" class="form-control" value='{{$videocloud}}'>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-6">
                <label>{{trans("gen.info.type")}}</label>
                <div class="form-group">
                    <label><input type="radio" id="type-chapter-{{Chapter::TYPE_MAIN}}" name="type-chapter" value="{{Chapter::TYPE_MAIN}}" <?php echo ((isset($chapter) && Chapter::TYPE_MAIN == $chapter->type) || !isset($chapter)) ? "checked" : null; ?>> {{trans("attr.chapter.type.".Chapter::TYPE_MAIN)}}</label> &nbsp;&nbsp;&nbsp;
                    <label> <input type="radio" id="type-chapter-{{Chapter::TYPE_EPISODE}}" name="type-chapter" value="{{Chapter::TYPE_EPISODE}}" <?php echo ((isset($chapter) && Chapter::TYPE_EPISODE == $chapter->type)) ? "checked" : null; ?>> {{trans("attr.chapter.type.".Chapter::TYPE_EPISODE)}}</label>
                </div>
            </div>
            <div class="col-md-6">
                <label>{{trans("gen.info.state")}}</label>
                <div class="form-group">
                    <label><input type="radio" id="state-chapter-{{Chapter::STATE_AVAILABLE}}" name="state-chapter" value="{{Chapter::STATE_AVAILABLE}}" <?php echo ((isset($chapter) && Chapter::STATE_AVAILABLE == $chapter->state) || !isset($chapter)) ? "checked" : null; ?>> {{trans("attr.chapter.state.".Chapter::STATE_AVAILABLE)}}</label> &nbsp;&nbsp;&nbsp;
                    <label> <input type="radio" id="state-chapter-{{Chapter::STATE_OFFLINE}}" name="state-chapter" value="{{Chapter::STATE_OFFLINE}}" <?php echo ((isset($chapter) && Chapter::STATE_OFFLINE == $chapter->state)) ? "checked" : null; ?>> {{trans("attr.chapter.state.".Chapter::STATE_OFFLINE)}}</label>
                </div>
            </div>
            <div class="col-md-4">
                <label>{{trans("gen.info.languages")}}</label>
                <div class="form-group">
                    @foreach($langs as $lang => $value)
                    <label class="checkbox-inline">
                        <input type="checkbox" class="checkbox-circle lang-chapter" id="language-chapter-{{$lang}}" value="{{$lang}}" <?php echo (isset($chapter) && in_array($lang, $chapter->languages)) ? "checked" : null; ?>/> {{$value}}
                    </label><br/>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <label>{{trans("gen.info.subtitles")}}</label>
                <div class="form-group">
                    @foreach($subs as $sub => $value)
                    <label class="checkbox-inline">
                        <input type="checkbox" class="checkbox-circle subs-chapter" id="subtitle-chapter-{{$sub}}" value="{{$sub}}" <?php echo (isset($chapter) && in_array($sub, (is_null($chapter->subtitles)) ? array() : $chapter->subtitles)) ? "checked" : null; ?>/> {{$value}}
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
                            <input type="radio" class="quality-chapter" id="quality-chapter-{{$quality}}" name="quality-chapter" value="{{$quality}}" <?php echo (isset($chapter) && $quality == $chapter->quality) ? "checked" : null; ?>> {{$value}}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div id="display-chapters" style='{{($isVideoMain || count($chapters)==0)?'display:none;':null}}'> 
        <h3>{{trans("gen.info.episodes")}} <button class="btn btn-primary" onclick="resetVideo();"><span class="glyphicon glyphicon-plus-sign"></span> {{trans("gen.info.add")}}</button></h3>
        <table id="table-chapters" class="table table-striped table-hover">
            <tr>
                <th style="text-transform: uppercase;">{{trans("gen.info.name")}}</th>
                <th style="text-transform: uppercase;">{{trans("gen.info.language")}}</th>
                <th style="text-transform: uppercase;">{{trans("gen.info.quality")}}</th>
                <th style="text-transform: uppercase;">{{trans("gen.info.state")}}</th>
                <th></th>
            </tr>
            @if(!$isVideoMain)
            @foreach($chapters as $chapter)
            <tr id='chapter-{{$chapter->id}}' onClick='openFormVideo({{$chapter->id}},"{{$chapter->name}}","{{str_replace('"',"",$chapter->video)}}","{{$chapter->quality}}",[{{Util::formatResultArray($chapter->languages,",","\"","\"")}}],[{{Util::formatResultArray($chapter->subtitles,",","\"","\"")}}],"{{$chapter->state}}")'>
                <td id='name-{{$chapter->id}}'>{{$chapter->name}}</td>
                <td id='languages-{{$chapter->id}}'>
                    @foreach($chapter->languages as $lang)
                    ({{trans("attr.language.".$lang)}}) 
                    @endforeach
                </td>
                <td id='quality-{{$chapter->id}}'>
                    {{trans("attr.chapter.quality.".$chapter->quality)}}
                </td>
                <td id='state-{{$chapter->id}}'>
                    {{trans("attr.chapter.state.".$chapter->state)}}
                </td>
                <td><span onClick='deleteChapter({{$chapter->id}});' class='glyphicon glyphicon-remove-circle'></span></td>
            </tr>
            @endforeach
            @endif
        </table>
    </div>
</div>


@stop


@section("script")
<script>

                                            var id_chapters = [<?php echo Util::formatResultObjects($chapters, "id"); ?>];</script>

<script>
                                            function deleteChapter(id){
                                            resetVideo();
                                                    $("#chapter-" + id).fadeOut(function(){$("#chapter-" + id).remove()});
                                                    var data = {
                                                    "_token": "{{ Session::token() }}",
                                                            "{{Chapter::ATTR_ID}}":id
                                                    };
                                                    $.ajax({
                                                    url: "{{URL::to('manager/productions/ajax/chapter/delete')}}",
                                                            type: 'POST',
                                                            dataType: 'json',
                                                            data: data,
                                                            success: function (response) {
                                                            }
                                                    });
                                            }
</script>
<script>
                                    function openFormVideo(id, name, video, quality, languages, subtitles, state){
                                    resetVideo();
                                            $("#form-add-video").show();
                                            $("#id-chapter").val(id);
                                            $("#name-chapter").val(name);
                                            $("#video-chapter").val(video);
                                            $("#quality-chapter-" + quality).prop("checked", true);
                                            for (var i = 0; i < languages.length; i++){
                                    $("#language-chapter-" + languages[i]).prop("checked", true);
                                    }

                                    for (var i = 0; i < subtitles.length; i++){
                                    $("#subtitle-chapter-" + subtitles[i]).prop("checked", true);
                                    }

                                    $("#state-chapter-" + state).prop("checked", true);
                                            $("#type-chapter-EP").prop("checked", true);
                                    }
</script>
<script>
                                    function addEpisode(id, name, video, quality, languages, subtitles, state){
                                    if (id_chapters.indexOf(id) < 0){
                                    $("#table-chapters").append("<tr id='chapter-" + id + "'  onClick='openFormVideo(" + id + ",\"" + name + "\",\"" + video + "\",\"" + quality + "\",[" + languages + "],[" + subtitles + "],\"" + state + "\")'>"
                                            + "<td id='name-" + id + "'>" + name + "</td><td id='languages-" + id + "'>" + languages + "</td><td id='quality-" + id + "'>" + quality + "</td><td id='state-" + id + "'>" + state + "</td></tr>");
                                            id_chapters.push(id);
                                    } else{
                                    $("#chapter-" + id).remove();
                                            $("#table-chapters").append("<tr id='chapter-" + id + "'  onClick='openFormVideo(" + id + ",\"" + name + "\",\"" + video + "\",\"" + quality + "\",[" + languages + "],[" + subtitles + "],\"" + state + "\")'>"
                                            + "<td id='name-" + id + "'>" + name + "</td><td id='languages-" + id + "'>" + languages + "</td><td id='quality-" + id + "'>" + quality + "</td><td id='state-" + id + "'>" + state + "</td></tr>");
                                    }
                                    }
</script>

<script>
                                    function resetVideo(){
                                    $("#form-add-video").show();
                                            $("#id-chapter").val("");
                                            $("#name-chapter").val("");
                                            $("#video-chapter").val("");
                                            $(".quality-chapter").prop("checked", false);
                                            $(".subs-chapter").prop("checked", false);
                                            $(".lang-chapter").prop("checked", false);
                                            $("#type-chapter-EP").prop("checked", true);
                                    }
</script>

<script>
                                    $("#btn-guardar-shapter").click(function(){

                                    $(this).html("<img src='{{URL::to('assets/images/loaders/barfb.gif')}}'/>");
                                            $(this).attr("disabled", "disabled");
                                            var name = $("#name-chapter").val();
                                            var video = $("#video-chapter").val();
                                            var quality = $('input[name=quality-chapter]:radio:checked').val();
                                            var langs = new Array();
                                            $(".lang-chapter").each(function(){
                                    if ($(this).is(':checked'))
                                            langs.push($(this).val());
                                    });
                                            var subs = new Array();
                                            $(".subs-chapter").each(function(){
                                    if ($(this).is(':checked'))
                                            subs.push($(this).val());
                                    });
                                            var type = $('input[name=type-chapter]:radio:checked').val();
                                            var state = $('input[name=state-chapter]:radio:checked').val();
                                            var data = {
                                            "_token": "{{ Session::token() }}",
                                                    "{{Chapter::ATTR_PRODUCTION_ID}}":"{{$production->id}}",
                                                    "{{Chapter::ATTR_NAME}}":name,
                                                    "{{Chapter::ATTR_VIDEO}}":video,
                                                    "{{Chapter::ATTR_LANGUAGES}}":langs,
                                                    "{{Chapter::ATTR_SUBTITLES}}":subs,
                                                    "{{Chapter::ATTR_QUALITY}}":quality,
                                                    "{{Chapter::ATTR_TYPE}}":type,
                                                    "{{Chapter::ATTR_STATE}}":state};
                                            if (parseInt($("#id-chapter").val()) > 0)
                                            data["{{Chapter::ATTR_ID}}"] = $("#id-chapter").val();
                                            $.ajax({
                                            url: "{{URL::to('manager/productions/ajax/chapter/creator')}}",
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: data,
                                                    success: function (response) {
                                                    $("#btn-guardar-shapter").html("<span class='glyphicon glyphicon-save'></span> {{trans('gen.info.save')}}");
                                                            $("#btn-guardar-shapter").removeAttr("disabled");
                                                            if (type == "{{Chapter::TYPE_EPISODE}}"){
                                                    $("#display-chapters").show();
                                                            addEpisode(response.id, response.name, response.video, response.quality, response.languages, response.subtitles, response.state);
                                                    }
                                                    }
                                            });
                                    });</script>


<script>

                                            function submit(state){
                                            $("#state").val(state);
                                                    $("#form").submit();
                                            }

</script>

@stop