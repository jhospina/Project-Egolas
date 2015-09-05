@extends("ui/templates/gen")


@section("content")

<h2>Proximos estrenos</h2>
<div class="col-lg-12" id="content coming-son">
    @foreach($productions as $production)
    <img class="production" title="{{$production->title}}" src="{{$production->image}}">
    @endforeach
</div>

@stop