<?php

use App\System\Library\Complements\DateUtil;
use App\System\Models\QueueProductions;
use App\System\Models\Production;
use App\System\Library\Complements\Util;

?>
@extends("user/templates/gen",array("title"=>"<span class='glyphicon glyphicon-flag'></span> ".trans('ui.menu.item.requests'),"path"=>"user/contents/requests"))

@section("content")


<div class="col-lg-12" style="margin-top: 20px;margin-bottom: 20px;">
    <div class="col-sm-6">
        <h2 style="margin-top: 0;">Descripción Estados</h2>
        <table class="table table-condensed text-left">
            <tr><td>Producción en cola de procesamiento </td><td> <span class="glyphicon glyphicon-flag in-queue"></span></td></tr>
            <tr><td>Producción procesada y en espera para fuentes de video </td><td> <span class="glyphicon glyphicon-flag in-wait"></span></td></tr>
            <tr><td>Producción disponible </td><td> <span class="glyphicon glyphicon-flag available"></span></td></tr>
        </table>
    </div>
    <div class="col-sm-6 text-justify" id="attention-request">
        <b>Atención: </b> Las solicitud de producciones de los usuarios no nos obliga a incluir dicha producción. Las producciones solicitadas sirven al sistema como referencia de las preferencias de los usuarios, lo puede ocasionar que las priorice y las incluya en el catalogo antes que otras no solicitadas.
    </div>
</div>

<div id="set-request" class="col-lg-12 text-left">
    <button id="open-modal-request" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Solicitar producción</button>
</div>

@if(count($requests)>0)

<table id="table-requests" class="table text-left table-striped table-responsive">
    <th>Fecha</th><th>Producción</th><th class="link-imdb">Enlace IMDB</th><th class="text-center">Estado</th>
    @foreach($requests as $request)
    <?php
    $queue = QueueProductions::find($request->queue_id);
    if (is_null($queue->date_processed)) {
        $status = "in-queue";
    } else {
        $production = Production::find($queue->production_id);
        if ($production->state == Production::STATE_ACTIVE)
            $status = "available";
        else
            $status = "in-wait";
    }
    ?>
    <tr>
        <td>Hace {{DateUtil::calculateDifference($request->date)}}</td><td>{{$queue->name}}</td><td class="link-imdb">{{$queue->link}}</td><td class="text-center"><span class="glyphicon glyphicon-flag {{$status}}"></span></td>
    </tr>
    @endforeach
</table>

{{Util::pagination($requests)}}

@else

<div class="col-lg-12 witdout-info" style="padding: 40px;">
    <span class="glyphicon glyphicon glyphicon-flag"></span><br>
    <div>¿No encuentras una producción en nuestro catalogo? ¡Solicitala! </br><small>Aún no has realizado ninguna solicitud</small></div>
</div>

@endif

<div class="modal fade"  id="modal-request" tabindex="-1" role="dialog" aria-labelledby="modal-avatar" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="color:black;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 class="modal-title"><span class="glyphicon glyphicon-flag"></span> Solicitar producción</h1>
            </div>
            <div class="modal-body text-justify">
                <div id="instructions">
                    <h3>Instrucciones</h3>
                    <p>Para que podamos incluir la producción que deseas, necesitamos saber exactamente a cual te refieres. Para ello debe ingresar a la base de datos de producciones cinematográficas más grande del mundo, conocida como IMDB y obtener el enlace de la producción que deseas.</p>
                    <h4>Sigue estos pasos:</h4>
                    <ol>
                        <li>Ingresa a <a target="_blank" href="http://imdb.com">imdb.com</a></li>
                        <li>Busca el titulo de la producción que deseas que incluyamos en nuestro catalogo.<br/> (Para que lo puedas encontrar más facilmente, buscalo por su titulo en ingles.)</li>
                        <li>Copia la dirección de enlace de la producción.</li>
                        <li>Pega el enlace aquí...</li>
                    </ol>
                    <div class="form-group">
                        <label>Enlace de producción IMDB</label>
                        <input class="form-control input-lg" placeholder="http://imdb.com/title/..." id="link-imdb">
                    </div>
                    <div class="alert alert-danger" id="response-request" style="display: none;"></div>
                </div>
                <div id="result"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="cancel" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="send">Enviar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop

@section("script")

<script>
    var token = "{{Session::token()}}";
    var ajax_request = "{{URL::to('user/request/ajax/post/add')}}";
</script>

@stop
