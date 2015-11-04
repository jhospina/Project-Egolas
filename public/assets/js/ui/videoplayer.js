var video = $("video")[0];
var duration = 0;
var currentTime = 0;
//**************************
//INIT PLAYER
//**************************
$(document).ready(function () {
    video.volume = 0.5;
});

$(document).ready(function () {

//Muestra la interfaz del video
    $("html").mousemove(function () {
        $("#controls").show();
        $("#btn-back").show();
        if (!isVolumenShowed)
            $("#barProgress").show();
        $('body').css('cursor', 'pointer');
    });

    var movementTimer = null;
    $("html").mousemove(function (e)
    {
        clearTimeout(movementTimer);
        movementTimer = setTimeout(function ()
        {
            $("#controls").fadeOut();
            $("#barProgress").fadeOut();
            $('#volumen-control').fadeOut();
            isVolumenShowed = false;
            $("#btn-back").fadeOut();
            $('html').css('cursor', 'none');

        }, 2000);
    });

    /*
     $("iframe").height($(window).height()).width($(window).width());
     $("iframe").attr("height", $(window).height()).attr("width", $(window).width());
     
     $(window).resize(function () {
     $("iframe").height($(window).height()).width($(window).width());
     $("iframe").attr("height", $(window).height()).attr("width", $(window).width());
     });*/


});


//Control de pausa play y pantalla completa
$(document).ready(function () {

    $("#play").click(function () {
        playPause(this);
    });

    $("video").click(function () {
        playPause($("#play"));
    });

    $("#full-screen").click(function () {

        if ($(this).attr("data-fullscreen") == "false") {
            if (video.requestFullscreen) {
                video.requestFullscreen();
            } else if (video.mozRequestFullScreen) {
                video.mozRequestFullScreen();
            } else if (video.webkitRequestFullscreen) {
                video.webkitRequestFullscreen();
            }
            $(this).attr("data-fullscreen", "true");
            $(this).html("<span class='glyphicon glyphicon-resize-small'></span>");
        } else {
            $(this).attr("data-fullscreen", "false");
            $(this).html("<span class='glyphicon glyphicon-fullscreen'></span>");
            if (video.exitFullscreen) {
                video.exitFullscreen();
            } else if (video.mozExitFullScreen) {
                video.mozExitFullScreen();
            } else if (video.webkitExitFullscreen) {
                video.webkitExitFullscreen();
            }
        }
    });
});

//Activa la pausa -play
function playPause(btn) {
    if ($(btn).attr("data-state") == "play") {
        $(btn).attr("data-state", "pause");
        video.play();
        $(btn).html("<span class='glyphicon glyphicon-pause'></span>");
    } else {
        $(btn).attr("data-state", "play");
        video.pause();
        $(btn).html("<span class='glyphicon glyphicon-play'></span>");
    }
}

//************************************
//CONTROL DE VOLUMEN
//************************************

var isVolumenShowed = false;//Indica si se esta mostrando el control de volumen

$(document).ready(function () {
    $("#sound").click(function () {
        if (!isVolumenShowed)
        {
            $('#volumen-control').show();
            $("#barProgress").hide();
        }
        else {
            $('#volumen-control').hide();
            $("#barProgress").show();
        }
        isVolumenShowed = !isVolumenShowed;
    });

    $('#volumen-control').click(function (e) {
        var offset = $(this).offset();
        var posBar = $("#content-volumen").height() - (e.clientY - offset.top);
        $("#progress-vol").height(posBar);
        //Calcula el volumen final
        var volumen = posBar / $("#content-volumen").height();
        video.volume = (volumen < 0) ? 0 : volumen;
        if (volumen < 0.1)
            $("#sound").html("<span class='glyphicon glyphicon-volume-off'></span>");
        if (volumen > 0.1 && volumen < 0.7)
            $("#sound").html("<span class='glyphicon glyphicon-volume-down'></span>");
        if (volumen > 0.7)
            $("#sound").html("<span class='glyphicon glyphicon-volume-up'></span>");
    });


});


//************************************
//CONTROL DE PROGRESO
//************************************

$(document).ready(function () {
    updateDataVideo();

    //Establece una nueva posicion del video al hacer click en la barra de progreso
    $('#barProgress .content-bar').click(function (e) {
        var offset = $(this).offset();
        var posBar = (e.clientX - offset.left) / $(this).width();
        $("#bar-time").css("width", (posBar * 100) + "%");
        video.currentTime = posBar * duration;
    });

});
//Actualiza los datos del video
function updateDataVideo() {
    currentTime = video.currentTime;
    duration = video.duration;
    setTimeout(function () {
        updateDataVideo();
    }, 1000);
    updateProgressBar();
}

function updateProgressBar() {
    var progress = (currentTime / duration) * 100;
    $("#bar-time").css("width", progress + "%");
    $("#time").html(getTimeFormat(currentTime))
}

/** Obtiene el formato de tiempo 
 * 
 * @param {type} time
 * @returns {String}
 */
function getTimeFormat(time) {
    var hours = 0;
    var minutes = 0;
    var seconds = 0;

    time = parseInt(duration) - parseInt(time);

    hours = Math.floor((time / 60) / 60);
    minutes = Math.floor((time / 60) - hours * 60);
    seconds = Math.floor((time) - (minutes * 60)-3600);

    if (hours < 10)
        hours = "0" + hours;
    if (minutes < 10)
        minutes = "0" + minutes;
    if (seconds < 10)
        seconds = "0" + seconds;
    
    return hours + ":" + minutes + ":" + "" + seconds;
}





