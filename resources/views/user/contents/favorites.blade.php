<?php

use App\System\Library\Complements\Util;
?>
@extends("user/templates/gen",array("title"=>"<span class='glyphicon glyphicon-star'></span> ".trans('ui.menu.item.my.list.favorites'),"path"=>"user/contents/favorites"))

@section("content")

<div id="favorites">

    @foreach($favorites as $production)
    <div class="production" data-slug="{{$production->slug}}">
        <img class="img-thumbnail" src="{{$production->image}}">
        <div class="information">
            <div class="title">{{$production->title}}</div>
            <div class="description">
                {{Util::trimText($production->description, 150)}}
            </div>
            <div class="view-more"><span class="glyphicon glyphicon-plus-sign"></span> Clic para ver más</div>
        </div>
        <div class="delete-fav"><span class="glyphicon glyphicon-trash"></span> {{trans("gen.info.delete")}}</div>
    </div>
    @endforeach

</div>

@stop

@section("script")

<script>
var url_site="{{URL::to('')}}";
 </script>

@stop
