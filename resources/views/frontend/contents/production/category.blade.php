@extends("frontend/templates/gen",array("path"=>"frontend/contents/production/category"))

@section("title"){{$category->mote}}@stop

@section("css")

{{ HTML::style('assets/plugins/switchery/switchery.css', array('media' => 'screen')) }}



@section("content")

<div class="col-xs-12" id="head-category" style="margin-left:9px;padding-bottom: 9px;margin: 0px 0 20px;border-bottom: 1px solid #eee;">
    <div class="col-sm-6">
        <h1>{{ucfirst($category->mote)}}</h1>
    </div>
    <div class="col-sm-6">
        <div id="check-filter">
            <div class="col-xs-12"><input type="checkbox" class="js-switch filter" checked=""/></div>
            <div class="col-xs-12"><div class="col-xs-6 text-left">Todo</div><div class="col-xs-6 text-right">Disponibles</div></div>
        </div>
    </div>
</div>
<div id="load-productions">

</div>

@stop

@section("script")

{{ HTML::script('assets/plugins/switchery/switchery.js') }}

<script>
    var token = "{{Session::token()}}"
    var cat_id = "{{$category->id}}";
    var ajax_get_productions = "{{URL::to('ajax/productions/get/by/category')}}";
</script>
@stop


