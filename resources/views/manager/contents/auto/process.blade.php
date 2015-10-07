@extends("manager/ui/templates/main")

@section("title") {{trans("ui.menu.item.autogenerator")}}/{{trans("ui.menu.item.autogenerator.processes")}}@stop

@section("content")


<div class="col-md-8">
    <h1><span class="glyphicon glyphicon-cog"></span> {{trans("ui.menu.item.autogenerator")}}/{{trans("ui.menu.item.autogenerator.processes")}}</h1>

    <div class="well-sm well"><a href="{{URL::to("manager/auto/process/add")}}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> {{trans("ui.btn.add")}}</a></div>
    
    @include("ui/msg/index",array("message_id"=>2))

    <div class="col-lg-12">
        <table class="table table-striped">
            <tr><th>{{trans("gen.info.name")}}</th><th>{{trans("gen.info.description")}}</th><th>{{trans("gen.info.activated")}}</th><th></th></tr>
            @foreach($processes as $process)
            <tr><td>{{$process->name}}</td>
                <td>{{$process->description}}</td>
                <td>
                    <input data-id="{{$process->id}}" type="checkbox" class="js-switch" {{HtmlControl::setCheck($process->activated)}}>
                </td>
                <td><a href="{{URL::to("manager/auto/process/delete/".$process->id)}}" class="danger" title="{{trans("ui.btn.eliminar")}}"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
            </tr>
            @endforeach
        </table>
    </div>

</div>

@stop


@section("script")

<script>
    jQuery(".js-switch").change(function () {

        var checked = 0;
        var id = $(this).attr("data-id");
        if ($(this).is(':checked'))
            checked = 1;
        else
            checked = 0;
        $.ajax({
            url: "{{URL::to('manager/auto/process/ajax/activated')}}",
            type: 'POST',
            dataType: 'json',
            data: {"_token": "{{ Session::token() }}", id_process: id, check: checked},
            success: function (response) {
               
            }
        });
    });
</script>

@stop