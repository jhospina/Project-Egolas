//Dimensiones de la pantalla
var w_screen;
var h_screen;

var gen_w_production;
var gen_h_production;


$(document).ready(function () {
    w_screen = $(window).width();
    h_screen = $(window).height();
    gen_adapter();
});


function gen_handlerOver() {
    if (!isMobile()) {
        //OVER IN PRODUCTIÖN
        $("div.production").mouseenter(function () {
            // $(this).animate({"width": 214, "height": 318}, 50);
            $(this).children("a").children(".over").css("opacity",1);
        }).mouseleave(function () {
            // $(this).animate({"width": gen_w_production, "height": gen_h_production}, 50);
            $(this).children("a").children(".over").css("opacity",0);
        });

        $("div.production").click(function () {
            $(this).children("a").children(".over").children("span").attr("class", "glyphicon glyphicon-refresh glyphicon-refresh-animate");
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
    return (
            (navigator.userAgent.match(/Android/i)) ||
            (navigator.userAgent.match(/webOS/i)) ||
            (navigator.userAgent.match(/iPhone/i)) ||
            (navigator.userAgent.match(/iPod/i)) ||
            (navigator.userAgent.match(/iPad/i)) ||
            (navigator.userAgent.match(/BlackBerry/))
            );
}
