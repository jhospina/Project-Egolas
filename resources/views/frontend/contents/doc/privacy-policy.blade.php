@extends("frontend/templates/gen")

@section("title"){{trans("gen.doc.privacy.policy")}}@stop

@section("content")

<div class="content container text-justify">
    <h1 class="text-center">{{trans("gen.doc.privacy.policy")}}</h1>
@include("doc/privacy-policy")
</div>

@stop