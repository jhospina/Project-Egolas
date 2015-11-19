@extends("frontend/templates/gen",array("path"=>"frontend/contents/report/problem"))

@section("title")Reportar un problema @stop

@section("content")

<form id="form-report" action="{{URL::to("report/problem")}}" method="POST" enctype="multipart/form-data">
    <div class="content container desk">
        <div class="content container text-justify">
            <div class="page-header">
                <h1 class="text-center text-uppercase"><span class="glyphicon glyphicon-warning-sign"></span> Reportar un problema</h1>
            </div>
            @include("ui/msg/index",array("message_id"=>1))

            <div id="response-error" class="alert alert-danger" style="display: none;"></div>
            {{ csrf_field() }}
            <div class="col-xs-12">
                <div class="form-group">
                    <label>¿En donde está el problema?</label>
                    <select name="type" id="type" class="form-control input-lg">
                        <option value="0">Seleccionar</option>
                        @foreach($types as $type => $label)
                        <option value="{{$type}}">{{$label}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>¿Qué ha sucedido?</label>
                    <textarea id="description" maxlength="500" style="height:150px;" title="Explica brevemente lo que ha ocurrido y qué pasos podemos realizar para llegar al problema…" name="description" class="form-control input-lg" placeholder="Explica brevemente lo que ha ocurrido y qué pasos podemos realizar para llegar al problema…"></textarea>
                </div>
                <div class="form-group">
                    <label>Incluye una captura de pantalla si es necesario</label>
                    <input id="image" accept="image/*" class="filestyle" data-input="false" data-buttonText="Adjuntar imagen" name="image" type="file"></a>
                </div>
            </div>
            <div class="col-xs-12 text-right" style="margin-bottom: 20px;">
                <button type="button" class="btn btn-primary btn-lg" id="submit-btn">Enviar información</button>
            </div>
        </div>
    </div>
</form>

@stop

@section("script")
<script src="{{URL::to('assets/js/bootstrap-filestyle.min.js')}}"></script>
@stop