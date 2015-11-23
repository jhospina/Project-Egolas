<?php

use App\System\Library\Complements\DateUtil;
?>
@extends("manager/ui/templates/main",array("path"=>"manager/contents/videocloud/index"))

@section("title") Cuentas VideoCloud @stop

@section("content")


<div class="col-md-12">
    <h1><span class="glyphicon glyphicon-cloud"></span> Cuentas VideoCloud</h1>

    <div class="well well-sm">
        <a class="btn btn-primary" onclick="$('#modal-add').modal('show');"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
    </div>
</div>

@include("ui/msg/index",array("message_id"=>1))


<div class="col-xs-12 text-center">
    {{Util::pagination($accounts)}}
</div>
<div class="col-lg-12">
    <table class="table table-striped table-hover">
        <tr><th>ID</th><th>Email</th><th>Token</th><th>Player</th><th>Fecha de registro</th><th>Tiempo restante</th></tr>
        @foreach($accounts as $account)
        <?php $date=  new DateUtil($account->date);?>
        <tr  data-id="{{$account->id}}" class="production-index">
            <td>{{$account->id}}</td>
            <td>{{$account->email}}</td>
            <td>{{$account->token}}</td>
            <td>{{$account->player}}</td>
            <td>{{$date->getYear()}}-{{$date->getMonth()}}-{{$date->getDay()}}</td>
            <td>{{DateUtil::calculateDifference(DateUtil::getCurrentTime(),$account->end)}}</td>
        </tr>
        @endforeach
    </table>
    <div class="col-xs-12 text-center">
        {{Util::pagination($accounts)}}
    </div>
</div>

<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                 {{ csrf_field() }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar nueva cuenta VideoCloud</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control input-lg" name="email" type="text" value="">
                </div>
                <div class="form-group">
                    <label>Token</label>
                    <input class="form-control input-lg" name="token" type="text" value="">
                </div>
                <div class="form-group">
                    <label>Player</label>
                    <input class="form-control input-lg" name="player" type="text" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
            </form> 
        </div>
    </div>
</div>

@stop