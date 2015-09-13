@extends("manager/ui/templates/main")

@section("title") {{trans("ui.menu.item.productions")}}@stop

@section("content")


<div class="col-md-12">
    <h1><span class="glyphicon glyphicon-cog"></span> {{trans("ui.menu.item.productions")}}</h1>

    @include("ui/msg/index",array("message_id"=>2))

    <div class="col-lg-12">
        <table class="table table-striped">
            <tr><th>ID</th><th>{{trans("gen.info.title")}}</th><th>{{trans("gen.info.title.original")}}</th><th>{{trans("gen.info.slug")}}</th><th>{{trans("gen.info.rating")}}</th><th>{{trans("gen.info.duration")}}</th><th></th></tr>
            @foreach($productions as $production)
            <tr>
                <td>{{$production->id}}</td>
                <td>{{$production->title}}</td>
                <td>{{$production->title_original}}</td>
                <td>{{$production->slug}}</td>
                <td>{{(is_null($production->rating_rel))?trans("gen.info.undenfined"):$production->rating_rel}}</td>
                <td>{{(is_null($production->duration))?trans("gen.info.undenfined"):$production->duration." min"}}</td>
                <td><a href="{{URL::to("manager/productions/edit/".$production->id)}}" title="{{trans("gen.info.edit")}}"><span class="glyphicon glyphicon-edit"></span></a></td>
            </tr>
            @endforeach
        </table>

        {{$productions->render()}}

    </div>

</div>

@stop