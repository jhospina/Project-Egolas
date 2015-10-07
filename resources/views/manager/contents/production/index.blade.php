@extends("manager/ui/templates/main")

@section("title") {{trans("ui.menu.item.productions")}}@stop

@section("content")


<div class="col-md-12">
    <h1><span class="glyphicon glyphicon-cog"></span> {{trans("ui.menu.item.productions")}}</h1>

    @include("ui/msg/index",array("message_id"=>2))

    <div class="col-lg-12">
        <table class="table table-striped table-hover">
            <tr><th>ID</th><th>{{trans("gen.info.title")}}</th><th>{{trans("gen.info.title.original")}}</th><th>{{trans("gen.info.slug")}}</th><th>{{trans("gen.info.rating")}}</th><th>{{trans("gen.info.duration")}}</th></tr>
            @foreach($productions as $production)
            <tr  data-id="{{$production->id}}" class="production-index">
                <td>{{$production->id}}</td>
                <td>{{$production->title}}</td>
                <td>{{$production->title_original}}</td>
                <td>{{$production->slug}}</td>
                <td>{{(is_null($production->rating_rel))?trans("gen.info.undenfined"):$production->rating_rel}}</td>
                <td>{{(is_null($production->duration))?trans("gen.info.undenfined"):$production->duration." min"}}</td>
            </tr>
            @endforeach
        </table>

        {{$productions->render()}}

    </div>

</div>

@stop

@section("script")

<script>
    $(".production-index").click(function(){
      var url = "{{URL::to("manager/productions/edit")}}/"+$(this).attr("data-id");
      window.open(url, '_blank');
    });
</script>
@stop