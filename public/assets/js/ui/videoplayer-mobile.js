//SEARCH VIDEO
var token_video = 0;
$(document).ready(function () {
    if (portrait)
        return;
    if (poster.length > 0) {
        var imagen = new Image();
        imagen.onload = getVideo;
        imagen.src = poster;
    } else {
        getVideo();
    }
});

function getVideo() {
    $.ajax({
        url: search_video,
        type: 'POST',
        dataType: 'json',
        data: {"_token": token, id_video: id_video, production_id: production_id, token_video: ""},
        success: function (response) {
            if (response.error)
            {
                $(".spinner").hide();
                $("#msg-loader").html(response.error);
                return;
            }
            $("#msg-loader").html("Decodificando video...");
            setTimeout(function () {
                $("#video").attr("src", response.url + "/0");
                token_video = response.token;
                $("#curtain").fadeOut(function () {
                    $("#video").show();
                });
            }, 3000);

        }
    });
}

