@extends("frontend/templates/gen")

@section("title"){{trans("gen.doc.privacy.policy")}}@stop

@section("content")

<div class="content container text-justify">
    <div class="page-header">
        <h1 class="text-center text-uppercase">{{trans("gen.doc.privacy.policy")}}</h1>
    </div>
    @include("doc/privacy-policy")
</div>

@stop