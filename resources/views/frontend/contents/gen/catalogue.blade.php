@extends("frontend/templates/gen",array("path"=>"frontend/contents/gen/catalogue"))

@section("css")
<style>
    .production-not-available {
        filter: none;
        -webkit-filter: none;
        -moz-filter: none;
        -ms-filter: none;
        -o-filter: none;
    }
</style>
@stop

@section("content")

<h1 style="margin-left:9px;"><span class="glyphicon glyphicon-th"></span> Catalogo de referencia</h1>
<div id="load-productions">

</div>

@stop

@section("script")
<script>
    var token = "{{Session::token()}}"
    var ajax_get_productions = "{{URL::to('ajax/get/productions')}}";
</script>
@stop