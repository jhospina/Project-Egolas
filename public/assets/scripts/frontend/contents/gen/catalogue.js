var skip = 0;
var total_productions = -1;

$(document).ready(function () {
    
    loadProductions();
//Carga las productions cuando llegan al final de la pagina
    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()*0.5) {
            loadProductions();
        }
    });

});


function loadProductions() {
    if ($("#content-loader").length > 0 || total_productions == skip)
        return;

    $("#load-productions").append("<div id='content-loader'><div class='col-xs-5'></div><div class='col-xs-2'><div class='spinner'></div></div><div class='col-xs-5'></div></div>");

    if (skip == 0 && $("#load-productions .production").length > 0)
        skip = parseInt($("#load-productions .production").length);

    $.ajax({
        url: ajax_get_productions,
        type: 'POST',
        dataType: 'json',
        data: {"_token": token, skip: skip},
        success: function (response) {
            $("#content-loader").remove();
            skip += response.length;
            for (var i = 0; i < response.length; i++) {

                if (total_productions == -1)
                    total_productions = response[i].total;

                $("#load-productions").append(response[i].html);
            }

            gen_adapter();
        }
    });
}