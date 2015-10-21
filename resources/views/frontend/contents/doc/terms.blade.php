<?php use App\System\Library\Security\Hash; ?>
@extends("frontend/templates/gen")

@section("title"){{trans("gen.doc.terms")}}@stop

@section("content")

<div class="content container text-justify">
    <h1 class="text-center">{{trans("gen.doc.terms")}}</h1>
@include("doc/terms")
</div>





@stop
