@extends("manager/ui/templates/main")

@section("title") {{trans("ui.menu.item.autogenerator")}}/{{trans("ui.menu.item.autogenerator.live.productions")}}@stop

@section("content")



<h1><span class="glyphicon glyphicon-play-circle"></span> {{trans("ui.menu.item.autogenerator")}}/{{trans("ui.menu.item.autogenerator.live.productions")}}</h1>

@include("ui/msg/index",array("message_id"=>2))

<div class="col-md-12">

    <table id="table" class="table table-striped">

    </table>


</div>

@stop

@section("script")


<script>
    $.fn.selectRange = function (start, end) {
        if (!end)
            end = start;
        return this.each(function () {
            if (this.setSelectionRange) {
                this.focus();
                this.setSelectionRange(start, end);
            } else if (this.createTextRange) {
                var range = this.createTextRange();
                range.collapse(true);
                range.moveEnd('character', end);
                range.moveStart('character', start);
                range.select();
            }
        });
    };
</script>

<script>

    var productions_id = new Array();

    $(document).ready(function () {
        getProduction();
    });

    function getProduction() {
        $.ajax({
            url: "{{URL::to('manager/productions/ajax/get/records')}}",
            type: 'POST',
            dataType: 'json',
            data: {"_token": "{{ Session::token() }}", "count": 1},
            success: function (data) {
                data = data[0];
                var id = data["{{App\System\Models\Production::ATTR_ID}}"];

                if (productions_id.indexOf(id) < 0) {
                    productions_id.push(id);

                    $("#table #header-table").remove();

                    var header = "<tr id='header-table'><th>ID</th><th>{{trans('gen.info.title')}}</th><th>{{trans('gen.info.title.original')}}</th><th>{{trans('gen.info.slug')}}</th><th>{{trans('gen.info.rating')}}</th><th>{{trans('gen.info.duration')}}</th><th></th></tr>";

                    $("#table").prepend(header + "<tr>" +
                            "<td>" + id + "</td>" +
                            "<td class='attr' id='{{App\System\Models\Production::ATTR_TITLE}}-" + id + "'>" + data["{{App\System\Models\Production::ATTR_TITLE}}"] + "</td>" +
                            "<td class='attr' id='{{App\System\Models\Production::ATTR_TITLE_ORIGINAL}}-" + id + "'>" + data["{{App\System\Models\Production::ATTR_TITLE_ORIGINAL}}"] + "</td>" +
                            "<td class='attr' id='{{App\System\Models\Production::ATTR_SLUG}}-" + id + "'>" + data["{{App\System\Models\Production::ATTR_SLUG}}"] + "</td>" +
                            "<td class='attr' id='{{App\System\Models\Production::ATTR_RATING_REL}}-" + id + "'>" + data["{{App\System\Models\Production::ATTR_RATING_REL}}"] + "</td>" +
                            "<td class='attr' id='{{App\System\Models\Production::ATTR_DURATION}}-" + id + "'>" + data["{{App\System\Models\Production::ATTR_DURATION}}"] + "</td>" +
                            "<td></td>" +
                            "</tr>");

                    handlerClickEdit();
                }

                /*
                 setTimeout(function () {
                 getProduction();
                 }, 60000);*/

            }
        });
    }

</script>

<script>
    function handlerClickEdit() {
        $("td.attr").click(function () {
            
            var attr=($(this).attr("id").toString().split("-"))[0];
             var id=($(this).attr("id").toString().split("-"))[1];
             var id_td="#" + $(this).attr("id");
            
            if (!($("#" + $(this).attr("id") + " input").length > 0)) {
                $("#" + $(this).attr("id")).html("<input type='text' class='form-control' value='" + $("#" + $(this).attr("id")).html() + "'/>");
                //Enfoca en el input creado
                $("#" + $(this).attr("id") + " input").focus();
                //Posicina el cursor en la ultima posicion
                $("#" + $(this).attr("id") + " input").selectRange($("#" + $(this).attr("id") + " input").val().length);

                //Evento Enter en el input, actualiza la información
                $("#" + $(this).attr("id") + " input").keypress(function (event) {
                    var keycode = (event.keyCode ? event.keyCode : event.which);
                    if (keycode == '13') {
                         $(id_td).html($(this).val());
                        $.ajax({
                            url: "{{URL::to('manager/productions/ajax/post/edit/')}}",
                            type: 'POST',
                            dataType: 'json',
                            data: {"_token": "{{ Session::token() }}","id":id,"attr": attr,"value":$(this).val()},
                            success: function (data) {}});

                    }
                });

            }
        });
    }
</script>

@stop