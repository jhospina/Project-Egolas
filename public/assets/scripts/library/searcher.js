var search_active = false;

$(document).ready(function () {

    if ($("#search").length > 0) {
        search_active = true;
        handlerSearch();
    }

    $("#search-box").click(function () {
        //Muestra caja de texto del buscador
        if (!search_active) {
            $(this).html('<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span><input id="search" type="text" class="form-control" placeholder="Títulos, personas..."></div>');
            $(this).css("width", 65);
            $(this).css("height", 34);
            $("#search").focus();
            search_active = true;
            $(this).animate({"width": 260});
            $("#search").animate({"width": 200}, function () {
                $("#search-box").children(".input-group").append('<span id="loader-search" class="input-group-addon"><span class="glyphicon glyphicon-refresh"></span></span>');
                handlerSearch();
            });
        }
    });

});


function handlerSearch() {

    var url = $("#search-box").attr("data-url");

    $("#search").focusout(function () {
        //Desactiva la caja de busqieda
        if (search_active && $(this).val().length == 0) {
            $("#loader-search").remove();
            $("#search-box").animate({"width": 100});
            $(this).animate({"width": 0}, function () {
                $("#search-box").html('<a><span class="glyphicon glyphicon-search"></span> Buscar</a>');
                $("#search-box").css("height", 55);
            });
            search_active = false;
        }
    }).keypress(function (e) {
        //Inicia la peticio para la busqueda
        if (e.which == 13) {
            $("#loader-search .glyphicon").addClass("glyphicon-refresh-animate").css("color", "black");
            location.href = url + "/search/" + encodeURI($(this).val());
        }
    });
    ;
}