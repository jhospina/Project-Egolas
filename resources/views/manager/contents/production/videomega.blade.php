@extends("manager/ui/templates/main",array("path"=>"manager/contents/production/videomega"))

@section("title") VideoMega@stop

@section("content")

<h1>Generador de link de video desde VideoCloud - Brightcove para Videomega</h1>
<div class="col-md-12" style="margin-bottom: 40px;">

    <div class="form-group">
        <label>Fuente CSV</label>
        <textarea id="csv" class="form-control" style="height: 200px"></textarea>
    </div>
    <button id="send" class="btn btn-primary">Enviar</button>
</div>

<h2>LINKS PARA SUBIR</h2>
<div class="col-md-12" id="links">

</div>
<h2>INFO</h2>
<div class="col-md-12">
    <table  id="info" class="table table-striped">
        <tr><th>Titulo</th><th>Titulo encriptado</th><th>Lote</th><th>Enlace</th></tr>
    </table>
</div>
@stop


@section("script")

<script>
    var ajax_link = "{{URL::to('manager/productions/ajax/get/videos/csv')}}";
    var token = "{{Session::token()}}";
</script>
@stop