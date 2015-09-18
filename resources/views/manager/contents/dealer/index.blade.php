<?php
use App\System\Models\Dealer;
?>
@extends("manager/ui/templates/main")

@section("title"){{trans("ui.menu.item.contents.dealers")}}@stop

@section("content")


<div class="col-md-12">
    <h1><span class="glyphicon glyphicon-flag"></span> {{trans("ui.menu.item.contents.dealers")}}</h1>

        @include("ui/msg/index",array("message_id"=>2))
    
    <div class="well-sm well">
        <a href="{{URL::to("manager/dealers/creator/".$id_creator)}}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> {{trans("ui.btn.add")}}</a>
    </div>

        <table class="table table-striped">
            <tr><th>{{trans("gen.info.name")}}</th>
                <th>{{trans("gen.info.website")}}</th>
                <th>{{trans("gen.info.type")}}</th>
                <th>{{trans("gen.info.model")}}</th>
                <th></th>
            </tr> 
            @foreach($dealers as $dealer)
            <tr>
            <td>{{$dealer->name}}</td>
            <td>{{$dealer->website}}</td>
            <td>{{trans("attr.dealer.".Dealer::ATTR_TYPE.".".$dealer->type)}}</td>
            <td>{{trans("attr.dealer.".Dealer::ATTR_MODEL.".".$dealer->model)}}</td>
            <td><a href="{{URL::to("manager/dealers/creator/".$dealer->id)}}" title="{{trans("gen.info.edit")}}"><span class="glyphicon glyphicon-edit"></span></a></td>
            </tr>
            @endforeach
        </table>




</div>

@stop