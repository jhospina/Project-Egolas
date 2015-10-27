@extends("frontend/templates/gen",array("path"=>"frontend/contents/gen/browser","id_body"=>"browser"))

@section("css")
{{ HTML::style('assets/ui/slider/css/slider.css', array('media' => 'screen')) }}
<style>
    html,body{
        overflow-x: hidden;
    }
</style>
@stop

@section("content")

<div class="content-slider-productions">
    <div class="slider-bcot">
        <section>
            @foreach($productions as $production)
            <div class="content-item">
                <div class="item">
                    <a href="{{URL::to("production/".$production->slug)}}"><img class="production" title="{{$production->title}}" src="{{$production->image}}">
                        <div class="over">
                            <span class="glyphicon glyphicon-play-circle"></span>
                            {{$production->title}}
                        </div>
                    </a>


                </div>

            </div>
            @endforeach
        </section>
    </div>
</div>

<div id="categories">
    <?php foreach ($categories as $category): ?>
        <?php
        $productions = $category->productions;
        if (count($productions) < 10)
            continue;
        ?>
        <a href="{{URL::to("category/".$category->slug)}}"><h2 class="text-center title-category text-uppercase">{{ucfirst($category->name)}}</h2></a>
        <div class="content-slider-productions">
            <div class="slider-bcot">
                <section>
                    @foreach($productions as $production)
                    <div class="content-item">
                        <div class="item">
                            <a href="{{URL::to("production/".$production->slug)}}"><img class="production" title="{{$production->title}}" src="{{$production->image}}">
                                <div class="over">
                                    <span class="glyphicon glyphicon-play-circle"></span>
                                    {{$production->title}}
                                </div>
                            </a>

                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </div>
    </div>
    @endforeach
</div>


@stop

@section("script")
{{ HTML::script('assets/ui/slider/scripts/slider.js') }}
@stop