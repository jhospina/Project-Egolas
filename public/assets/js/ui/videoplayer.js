var video = $("video")[0];

$(document).ready(function () {

    $("body").mousemove(function () {
        $("#controls").show();
        $("#btn-back").show();
        $('body').css('cursor', 'pointer');
    });

    var movementTimer = null;
    $("body").mousemove(function (e)
    {
        clearTimeout(movementTimer);
        movementTimer = setTimeout(function ()
        {
            $("#controls").fadeOut();
            $("#btn-back").fadeOut();
            $('body').css('cursor', 'none');

        }, 4000);
    })


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
