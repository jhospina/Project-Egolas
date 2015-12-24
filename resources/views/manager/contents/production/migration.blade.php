<?php

use App\System\Library\Complements\Util;
use App\System\Models\Production;
use App\System\Models\QueueProductions;
use App\System\Models\VideoCloudAccount;
?>
@extends("manager/ui/templates/main",array("path"=>"manager/contents/production/migration"))

@section("title") {{trans("ui.menu.item.productions")}} @stop

@section("content")


<div class="col-md-12">
    <h1><span class="glyphicon glyphicon-transfer"></span> Migración de activos de video</h1>

    <div class="col-xs-6">
        <div><h2>Total de videos: <span>{{$total}}</span></h2></div>
        <div><h2>Videos cargados: <span id="videocount">0</span></h2></div>
        <div><h2>Procesados: <span id="readycount">0</span></h2></div>  
    </div>
    <div class="col-xs-6">
        <div><h2>Cuenta Videocloud a Migrar: {{VideoCloudAccount::getCurrentAccountEmail()}}</h2></div>
    </div>

    <div class="col-xs-12">
        <table id="videos" class="table table-bordered">

        </table>
    </div>

    @stop

    @section("script")

    <script>
        var ajax_loadVideo = "{{URL::to('manager/productions/ajax/get/video/migration')}}";
        var ajax_setVideo = "{{URL::to('manager/productions/ajax/set/video/id')}}";
        var token = "{{Session::token()}}";
        var total = "{{$total}}";
        var videocloud_id="{{(isset($_GET['account'])) ? $_GET['account'] : (VideoCloudAccount::getCurrentAccountId())}}";
    </script>
    @stop