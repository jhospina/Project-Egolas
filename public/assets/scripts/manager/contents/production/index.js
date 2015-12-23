$(document).ready(function () {
    $(".production-index").click(function () {
        var url = url_site + $(this).attr("data-id");
        window.open(url, '_blank');
    });

    $("#add-new").click(function () {
        $("#modal-add").modal("show");
    });



    $("#send").click(function () {

        $(this).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Procesando...");
        $(this).attr("disabled");
        $(this).addClass("disabled");

        $("#link_production").attr("disabled", "disabled");
        $("#name_production").attr("disabled", "disabled");

        $.ajax({
            url: ajax_add_new,
            type: 'POST',
            dataType: 'json',
            data: {"_token": token, link: $("#link_production").val(), name: $("#name_production").val()},
            success: function (response) {

                $("#report-moda-add").html(response.msg);
                $("#report-moda-add").fadeIn();
                $("#name_production").val("");
                $("#link_production").val("");
                $("#link_production").removeAttr("disabled");
                $("#name_production").removeAttr("disabled");
                $("#send").html("Enviar");
                $("#send").removeAttr("disabled");
                $("#send").removeClass("disabled");

                setTimeout(function () {
                    $("#report-moda-add").fadeOut()
                }, 5000);
            },
            error: function (request, status, error) {
                $("#report-moda-add").removeClass("alert-info");
                $("#report-moda-add").addClass("alert-danger");

                $("#report-moda-add").html("Ocurrio un error durante el procesamiento de la producción. La inclusión debe hacerse manualmente.");
                $("#report-moda-add").fadeIn();
                //$("#name_production").val("");
                //$("#link_production").val("");
                $("#link_production").removeAttr("disabled");
                $("#name_production").removeAttr("disabled");
                $("#send").html("Enviar");
                $("#send").removeAttr("disabled");
                $("#send").removeClass("disabled");

                setTimeout(function () {
                    $("#report-moda-add").fadeOut(function () {
                        $("#report-moda-add").removeClass("alert-dangerao");
                        $("#report-moda-add").addClass("alert-info");
                    })
                }, 5000);

            }
        });
    });

});