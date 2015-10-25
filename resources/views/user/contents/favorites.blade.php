<?php

use App\System\Library\Complements\Util;
?>
@extends("user/templates/gen",array("title"=>"<span class='glyphicon glyphicon-star'></span> ".trans('ui.menu.item.my.list.favorites'),"path"=>"user/contents/favorites"))

@section("content")

<div id="favorites">

</div>

@stop

@section("script")

<script>
var url_site="{{URL::to('')}}";
var ajax_rem_fav="{{URL::to('ajax/user/favorites/delete/production')}}";
var ajax_get_fav="{{URL::to('ajax/user/favorites/get/productions')}}";
var token="{{Session::token()}}";
 </script>

@stop
