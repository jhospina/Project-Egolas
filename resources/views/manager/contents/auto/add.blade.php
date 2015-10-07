@extends("manager/ui/templates/main")

@section("title") {{trans("ui.menu.item.1")}}/{{trans("ui.btn.add")}}@stop

@section("content")


<div class="col-md-6">
    <h1><span class="glyphicon glyphicon-cog"></span> {{trans("ui.menu.item.1")}}/{{trans("ui.btn.add")}}</h1>
    @include("ui/msg/index",array("message_id"=>2))

    <form method="POST" action="">
        {{ csrf_field() }}
        <div class="col-lg-12" style="margin-top: 20px;">
            <div class="form-group">
                <input class="input-lg form-control" name="name" type="text" placeholder="{{trans("sec.autoProcess.name.process")}}">
            </div>
            <div class="form-group">
                <textarea class="input-lg form-control" name="description" type="text" placeholder="{{trans("sec.autoProcess.description.process")}}"></textarea>
            </div>
            <div class="col-lg-12">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> {{trans("ui.btn.save")}}</button>
                </div>
            </div>
        </div>
    </form>


</div>

@stop
