<?php

use App\System\Library\Security\Hash; ?>
@extends("frontend/templates/gen")

@section("title"){{trans("gen.doc.terms")}}@stop

@section("content")

<div class="content container text-justify">
    <div class="page-header">
        <h1 class="text-center text-uppercase">{{trans("gen.doc.terms")}}</h1>
    </div>
    @include("doc/terms")
</div>





@stop
