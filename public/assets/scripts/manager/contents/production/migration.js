
var videocount = $("#videocount");
var readycount = $("#readycount");
var loading = false;

$(document).ready(function () {
    loadVideos();
});


function loadVideos() {
    loading = true;
    $.ajax({
        url: ajax_loadVideo,
        type: 'POST',
        dataType: 'json',
        data: {"_token": token, skip: parseInt(videocount.html())},
        success: function (response) {

            videocount.html(parseInt(videocount.html()) + response.length);

            for (var i = 0; i < response.length; i++) {
                $("#videos").append("<tr id='video-" + response[i].id + "'><td>" + response[i].id + "</td><td><input readonly='readonly' id='col-" + response[i].id + "' class='form-control url-video' type='text' value='" + response[i].url + "'></td><td><input class='form-control' type='text' id='video-id-" + response[i].id + "' placeholder='Nuevo video ID...'></td><td><button onclick='setVideoId(" + response[i].id + ")'>Establecer</button></td></tr>");
            }
            loading = false;
            handlers();
        }});
}


function handlers() {
    $("input.url-video").click(function () {
        $(this).select();
    });
}


function setVideoId(video_id) {
    var video = $("#video-id-" + video_id).val();
    $("#video-" + video_id).remove();
    readycount.html(parseInt(readycount.html()) + 1);
//Estable el nuevo ID del video
    $.ajax({
        url: ajax_setVideo,
        type: 'POST',
        dataType: 'json',
        data: {"_token": token, video: video, id: video_id},
        success: function (response) {
            if ($("#videos tr").length <= 20 && loading == false) {
                if (parseInt(readycount.html()) < parseInt(total))
                    loadVideos();
            }
        }});
}