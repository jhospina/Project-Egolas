$(document).ready(function () {

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() == $(document).height()) {
            loadProductions();
        }
    });
    loadProductions();
});


var skip = 0;
var total_productions = -1;
var request = null;
function loadProductions() {

    if ($("#content-loader").length > 0 || total_productions == skip)
        return;
    $("#favorites").append("<div id='content-loader' class='col-lg-12'><div class='col-xs-5'></div><div class='col-xs-2'><div class='spinner'></div></div><div class='col-xs-5'></div></div>");
    if (skip == 0 && $("#favorites .production").length > 0)
        skip = parseInt($("#favorites .production").length);

    //PETICICION AJAX
    $.ajax({
        url: ajax_get_fav,
        type: 'POST',
        dataType: 'json',
        data: {"_token": token, skip: skip},
        success: function (response) {

            request = response;

            $("#content-loader").remove();
            skip += response.length;

            for (var i = 0; i < response.length; i++) {
                if (total_productions == -1)
                    total_productions = response[i].total;
                if (total_productions == 0) {

                    $("#favorites").html("<div class='col-xs-12 text-center' style='margin-top:100px;'><h2><span class='glyphicon glyphicon-ban-circle'></span> <i>Aún no tienes nada en tu lista de favoritos</i></h2></div>");
                    skip = 0;
                    return;
                }

                var html = "<div class='production' id='production-" + response[i].id + "' data-slug='" + response[i].slug + "' data-id='" + response[i].id + "'>" +
                        "<img class='img-thumbnail' src='" + response[i].image + "'>" +
                        "<div class='information'>" +
                        "<div class='title'>" + response[i].title + "</div>" +
                        "<div class='description'>" +
                        response[i].description +
                        "</div>" +
                        "<div class='view-more'><span class='glyphicon glyphicon-plus-sign'></span> Clic para ver más</div>" +
                        " </div>" +
                        "<div class='delete-fav'><span class='glyphicon glyphicon-trash'></span> Eliminar</div>" +
                        "</div>";
                $("#favorites").append(html);

            }

            fade();
            handlers();
        }
    });


    //COntrolladores de evento
    function handlers() {

        $("#favorites .production .information").click(function () {
            window.open(url_site + "/production/" + $(this).parent().attr("data-slug"), "_blank");
        });

        $("#favorites .production .information").mouseover(function () {
            $(this).css("opacity", 1);
        });

        $("#favorites .production .information").mouseout(function () {
            $(this).css("opacity", 0);
        });

        $("#favorites .production .delete-fav").click(function () {

            $(this).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Eliminando...");
            $(this).attr("disabled");
            $(this).addClass("disabled");
            $(this).unbind("click");

            var btn = this;

            var production_id = $(this).parent().attr("data-id");


            $.ajax({
                url: ajax_rem_fav,
                type: 'POST',
                dataType: 'json',
                data: {"_token": token, production_id: production_id},
                success: function (response) {
                    $(btn).parent().fadeOut(function () {
                        $(btn).parent().remove();
                    });

                }
            });
        });


    }

//Muestra cada produccion en secuencia fade
    var f = 0;
    var cant_fade = 0; //Indica la cantidad de produccion que se estan mostrando
    function fade() {
        f = 0;
        for (var i = 0; i < request.length; i++) {
            setTimeout(function () {
                $("#production-" + request[f].id).fadeIn();
                f++;
                cant_fade++;
            }, i * 100);
        }

//Evita que produccion se queden sin mostrar por fade
        setTimeout(function () {
            if (total_productions != cant_fade) {
                $("#favorites .production").fadeIn();
            }
        }, 100 * request.length)
    }

}