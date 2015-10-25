@extends("frontend/templates/gen",array("path"=>"frontend/contents/gen/browser","id_body"=>"browser"))

@section("css")
{{ HTML::style('assets/ui/slider/css/slider.css', array('media' => 'screen')) }}

@stop

@section("content")

<h2><span class="glyphicon glyphicon-film"></span> {{trans("gen.info.added.recently")}}</h2>
<div class="content-slider-productions">
    <div class="slider-bcot">
        <section>
            @foreach($productions as $production)
            <div class="content-item">
                <div class="content-production item">
                    <a href="{{URL::to("production/".$production->slug)}}"><img class="tooltip-bottom production" title="{{$production->title}}" src="{{$production->image}}"></a>
                </div>
            </div>
            @endforeach
        </section>
    </div>
</div>

@stop

@section("script")
{{ HTML::script('assets/ui/slider/scripts/slider.js') }}
@stop