//Dimensiones de la pantalla
var w_screen;
var h_screen;
var menu_mobile = false;
var gen_w_production;
var gen_h_production;


$(document).ready(function () {
    w_screen = $(window).width();
    h_screen = $(window).height();
    gen_adapter();

    $(window).scroll(function () {
        if ($(window).scrollTop() <= 80) {
            $("#navbar").show();
        } else {
            if (h_screen <= 400)
                $("#navbar").hide();
        }
    });

    //Menu - Mobile
    $("#go-menu-mobile").click(function () {
        if (!menu_mobile) {
            $("body").css("position", "absolute").css("right", "0px").css("overflow", "hidden");
            $("body").animate({"right": "200px"}, 500, function () {
                menu_mobile = true;
            });

            $("#overligth-menu-mob").fadeIn(500);
            $("#menu-mobile")
                    .css("height", (h_screen + 50) - parseInt(($("#menu-mobile").css("top")).toString().replace("px", "")))
                    .css("right", "-" + $("#menu-mobile").css("width"))
                    .show()
                    .animate({"right": "0px"}, 500);
            $(this).css("background", "white");
            $(this).children("a").children(".glyphicon").css("color", "black");

        } else {
            $(this).css("background", "none");
            $(this).children("a").children(".glyphicon").css("color", "white");
            $("#overligth-menu-mob").fadeOut(500);
            $("body").animate({"right": "0px"}, 500, function () {
                menu_mobile = false;
                $("body").css("position", "static").css("overflow-y", "initial");
            });
            $("#menu-mobile").animate({"right": "-" + $("#menu-mobile").css("width")}, 500, function () {
                $(this).hide();
            });
        }
    });

    $("#btn-search-mob").click(function () {
        if ($("#search-mob").val().length > 0)
            location.href = url_site + "/search/" + encodeURI($("#search-mob").val());
    });

});


function gen_handlerOver() {

    if (!isMobile()) {
        //OVER IN PRODUCTIÖN
        $("div.production").mouseenter(function () {
            // $(this).animate({"width": 214, "height": 318}, 50);
            $(this).children("a").children(".over").css("opacity", 1);
        }).mouseleave(function () {
            // $(this).animate({"width": gen_w_production, "height": gen_h_production}, 50);
            $(this).children("a").children(".over").css("opacity", 0);
        });

        $("div.production").click(function () {
            if ($(this).children("a").children("img").hasClass("production-not-available")) {
                $(this).children("a").children(".over").children("span").attr("class", "glyphicon glyphicon-refresh glyphicon-refresh-animate");
            }
        });
    } else {
        $("div.item").click(function () {
            //$(this).children("a").children(".over").css("opacity", 1);
            // $(this).children("a").children(".over").children("span").attr("class", "glyphicon glyphicon-refresh glyphicon-refresh-animate");
        });
        $("div.production").click(function () {
            // $(this).children("a").children(".over").css("opacity", 1);
            // $(this).children("a").children(".over").children("span").attr("class", "glyphicon glyphicon-refresh glyphicon-refresh-animate");
        });
    }
}

function gen_adapter() {

    gen_h_production = $("div.production").height();
    gen_w_production = $("div.production").width();

    /**
     * DETERMINA EL TAMAÑO DE LOS POSTER SEGUN EL TAMAÑO DE LA PANTALLA
     */
    if (w_screen < 900 && w_screen > 400)
    {
        gen_h_production = (gen_h_production * 150) / gen_w_production;
        gen_w_production = 150;
        $("div.production").css("width", gen_w_production).css("height", gen_h_production).css("display", "inline-block").css("float", "initial");
        $("#main").css("text-align", "center");
    }

    if (w_screen <= 400)
    {
        gen_h_production = (gen_h_production * 100) / gen_w_production;
        gen_w_production = 100;
        $("div.production").css("width", gen_w_production).css("height", gen_h_production).css("display", "inline-block").css("float", "initial");
        $("#main").css("text-align", "center");
    }

    gen_handlerOver();
}


function isMobile() {
    return ((navigator.userAgent.match(/Android/i)) ||
            (navigator.userAgent.match(/webOS/i)) ||
            (navigator.userAgent.match(/iPhone/i)) ||
            (navigator.userAgent.match(/iPod/i)) ||
            (navigator.userAgent.match(/iPad/i)) ||
            (navigator.userAgent.match(/BlackBerry/))
            );
}


function modalProduction(id) {

    var content = $("#view-production-play").parent();

    if ($("#img-production-" + id).hasClass("production-not-available"))
    {
        location.href = $("#url-" + id).html();
        return;
    }

    $("#modal-view-production .content-chapters").remove();

    //Si es una serie
    if ($("#chapters-" + id).length > 0) {

        $("#view-production-play").hide();
        $("#view-production-title-chapters").show();

        //Obtiene los enlace de los capitulos
        var data = $.parseJSON($("#chapters-" + id).html());

        var html = "<div class='well well-sm content-chapters'>";

        for (var i = 0; i < data.length; i++) {
            var chapter_name = data[i][0];
            var chapter_link = data[i][1];
            html += '<a class="btn btn-lg btn-danger btn-block" style="text-align: left;" id="view-production-play" href="' + chapter_link + '"><span class="glyphicon glyphicon-play-circle"></span> ' + chapter_name + '</a>';

        }

        content.append(html + "</div>");
    } else {
        $("#view-production-play").show();
        $("#view-production-title-chapters").hide();
    }

    $("#view-production-title").html($("#img-production-" + id).attr("title"));
    $("#view-production-image").attr("src", $("#img-production-" + id).attr("src"));

    $("#view-production-play").attr("href", $("#url-" + id).html() + "/play");
    $("#view-production-info").attr("href", $("#url-" + id).html());
    $("#modal-view-production").modal("show");
}

