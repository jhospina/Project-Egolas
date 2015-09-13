@extends("manager/ui/templates/main")

@section("title") {{trans("ui.user.menu.edit.password")}} @stop

@section("content")




<div class="col-md-4 col-md-offset-4">


    <h1 class="text-center"><span class="glyphicon glyphicon-lock"></span> {{trans("ui.user.menu.edit.password")}}</h1>

    @include("ui/msg/index",array("message_id"=>2))


    <form method="POST" action="">
        <table class="table table-striped">
            {{ csrf_field() }}
            <tr><th>{{trans("sec.editpass.pass.current")}}</th><td>    {{ Form::password('pass',array('class' => 'form-control')) }}</td></tr>
            <tr><th>{{trans("sec.editpass.pass.new")}}</th><td>{{ Form::password('pass-new',array('class' => 'form-control')) }}</td></tr>
            <tr><th>{{trans("sec.editpass.pass.repeat")}}</th><td>{{ Form::password('pass-rep',array('class' => 'form-control')) }}</td></tr>
        </table>

        <div class="well-lg text-center">
            <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-check'></span>{{trans("ui.btn.apply")}}    </button>

        </div>
    </form>
</div>



@stop