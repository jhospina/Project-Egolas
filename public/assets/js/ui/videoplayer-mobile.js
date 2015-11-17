//SEARCH VIDEO
var token_video = 0;
$(document).ready(function () {
    if (portrait)
        return;
    var imagen = new Image();
    imagen.onload = getVideo;
    imagen.src = poster;
});

function getVideo() {
    $.ajax({
        url: search_video,
        type: 'POST',
        dataType: 'json',
        data: {"_token": token, id_video: id_video, production_id: production_id},
        success: function (response) {
            if (response.error)
            {
                $(".spinner").hide();
                $("#msg-loader").html(response.error);
                return;
            }
            $("#msg-loader").html("Decodificando video...");
            setTimeout(function () {
                $("#video").attr("src", response.url);
                token_video = response.token;
                $("#curtain").fadeOut(function () {
                    $("#video").show();
                });
            }, 3000);

        }
    });
}

window.onbeforeunload = function () {
    $.ajax({
        url: close_video,
        type: 'POST',
        dataType: 'json',
        data: {"_token": token, token_video: token_video}
    });
}



