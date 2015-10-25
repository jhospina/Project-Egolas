var arrow_right = "<div class='arrow arrow-right' data-dir='right'><span class='glyphicon glyphicon-chevron-right'></span></div>";
var arrow_left = "<div class='arrow arrow-left' data-dir='left'><span class='glyphicon glyphicon-chevron-left'></span></div>";
var slider = $(".slider-bcot section");
var num_show;//Cantidad de items a mostrar en pantalla
//Dimensiones de los items
var h_item;
var w_item;
//Dimensiones de la pantalla
var w_screen;
var h_screen;

$(document).ready(function () {
    //Obtiene la altura del item del slider para ajustarlo al tamaño adecuado
    h_item = $(".slider-bcot .item").height();
    w_item = $(".slider-bcot .item").width();

    w_screen = $(window).width();
    h_screen = $(window).height();
    adapter();
});


function init() {
    //Se le asigna la altura adecuada al slider
    $(".slider-bcot").css("height", h_item);
    //Se le asigna el ancho total al contenedor que contiene los items del slider
    $(".slider-bcot section").css("width", h_item * $(".slider-bcot .item").length).css("heigth", h_item);
    //Contruye las flechas de movimiendo del slider
    $(".slider-bcot").append(arrow_right);
    //Asigna las propiedades de las flechas de movimiento
    $(".slider-bcot .arrow").css("height", $(".slider-bcot").height());
    handlers();
}


function handlers() {

    //Muestra las flechas cuando se posiciona en el slider
    $(".slider-bcot").mouseenter(function () {
        $(".slider-bcot .arrow").fadeIn();
    }).mouseleave(function () {
        $(".slider-bcot .arrow").fadeOut();
    });

    $(".slider-bcot .arrow").mouseenter(function () {
        $(this).children(".glyphicon").animate({"font-size": "30pt"}, 200);
    }).mouseleave(function () {
        $(this).children(".glyphicon").animate({"font-size": "20pt"}, 200);
    }).click(function () {

        //Se obtiene la posicion actual del slider
        var pos = parseInt(slider.css("left").toString().replace("px", ""));

        if ($(this).attr("data-dir") == "right")
        {
            //Mueve el slider a la izquierda
            slider.animate({"left": pos - (num_show * w_item)}, function () {
                $(this).children(".content-item").each(function (i) {
                    if (i < num_show) {
                        //Obtiene los items movidos y los posiciona al final
                        var item = $(this).html();
                        $(this).remove();
                        slider.append("<div class='content-item'>" + item + "</div>");
                        slider.css("left", "0");
                    }
                });
            });
        } else {
            //Mueve el slider a la derecha
        }
    });
}


function adapter() {


    if (w_screen < 900 && w_screen > 400)
    {
        h_item = (h_item * 150) / w_item;
        w_item = 150;
        $(".slider-bcot .item").css("width", w_item).css("height", h_item);
    }

    if (w_screen <= 400)
    {
        h_item = (h_item * 100) / w_item;
        w_item = 100;
        $(".slider-bcot .item").css("width", w_item).css("height", h_item);
    }


    num_show = Math.floor(w_screen / w_item);
    init();
}