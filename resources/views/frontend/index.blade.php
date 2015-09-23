@extends("ui/templates/gen")


@section("content")

<h2><span class="glyphicon glyphicon-film"></span> {{trans("gen.info.added.recently")}}</h2>
<div class="col-lg-12" id="content coming-son">
    @foreach($productions_recently as $production)
    <div class="content-production">
        <a href="{{URL::to("f/production/".$production->slug)}}"><img class="tooltip-bottom production" title="{{$production->title}}" src="{{$production->image}}"></a>
    </div>
    @endforeach
</div>

@stop