var skip = 0;
var total_productions = -1;
var filtered = true;//Todo True => Mostrar solo disponibles True => Mostrar todo
$(document).ready(function () {
    loadProductions();
//Carga las productions cuando llegan al final de la pagina
    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height()  >= $(document).height()*0.5) {
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
        data: {"_token": token, category_id: cat_id, skip: skip, filtered: filtered},
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


$(document).ready(function () {
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    elems.forEach(function (html) {
        var switchery = new Switchery(html, {secondaryColor: 'gray', className: "switchery switchery-small"});
    });

    jQuery(".js-switch.filter").change(function () {
        skip = 0;
        total_productions = -1;
        $("#load-productions").html("");
        filtered = $(this).is(':checked');
        loadProductions();
    });
});
