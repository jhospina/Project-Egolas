<?php

use App\System\Library\Complements\Util;
use \App\System\Models\Dealer;
?>

@extends("ui/templates/gen")

@section("title"){{$person->name}}@stop

@section("css")
{{ HTML::style('assets/css/frontend/person/info.css', array('media' => 'screen')) }}
@stop

@section("content")




@stop