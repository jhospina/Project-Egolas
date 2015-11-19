<?php

use App\System\Models\User;
use App\System\Library\Complements\DateUtil;
?>

@extends("manager/ui/templates/main")

@section("title") Reporte de problemas @stop

@section("content")


<h1><span class='glyphicon glyphicon-alert'></span> Reportes</h1>
<div class="col-xs-12 text-center">
    {{Util::pagination($reports)}}
</div>

<div class="col-lg-12">
    <table class="table table-striped table-hover">
        <tr><th>ID</th><th>Usuario</th><th>Email</th><th>Problema</th><th>Tiempo</th><th>Descripción</th><th>Imagen</th></tr>
        @foreach($reports as $report)
        <?php $user = User::findOrNew($report->user_id); ?>
        <tr>
            <td>{{$report->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{trans("attr.report.type.".$report->type)}}</td>
            <td>Hace {{DateUtil::calculateDifference($report->date)}}</td>
            <td>{{$report->description}}</td>
            <td>{{(!is_null($report->image))?"<a target='_blank' href='".$report->image."'>Imagen</a>":""}}</td>
        </tr>
        @endforeach
    </table>

    <div class="col-xs-12 text-center">
        {{Util::pagination($reports)}}
    </div>



    @stop
