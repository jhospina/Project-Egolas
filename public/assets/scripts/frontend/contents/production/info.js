
$(document).ready(function () {
    //Comentario
    $("#submit-post-comment").click(function () {
        $(this).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Enviando...");
        $(this).attr("disabled");
        $(this).addClass("disabled");

        $.ajax({
            url: ajax_post_comment,
            type: 'POST',
            dataType: 'json',
            data: {"_token": token, production_id: $("#production-id").val(), content: $("#content-comment").val()},
            success: function (response) {

                if ($("#content-not-comments").length > 0)
                    $("#content-not-comments").remove();

                if (total_comment != -1)
                    total_comment++;

                var html = "<div class='comment'>" +
                        "<div class='col-xs-1 col-md-1'>" +
                        "<img class='avatar img-circle' src='" + $("#create-comment .avatar").attr("src") + "'> " +
                        "</div>" +
                        "<div class='col-xs-11'>" +
                        " <div class='col-xs-4' style='padding-left:0px;'>" + name_user + "</div>" +
                        " <div class='col-xs-8 text-right'>Hace un momento</div>" +
                        " <div class='comment-content'>" +
                        response.content +
                        " </div>" +
                        " </div>" +
                        "  </div>";

                $("#list-comment").prepend(html);
                $("#content-comment").val("");
                $("#submit-post-comment").html("Comentar");
                $("#submit-post-comment").removeAttr("disabled");
                $("#submit-post-comment").removeClass("disabled");
            }
        });
    });

});


var skip = 0;
var total_comment = -1;
$(document).ready(function () {
    
    loadComments();

//Carga los comentarios cuando llegan al final de la pagina
    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() == $(document).height()) {
            loadComments();
        }
    });

});


function loadComments() {
    if ($("#content-loader").length > 0 || total_comment == skip)
        return;

    $("#list-comment").append("<div id='content-loader'><div class='col-xs-5'></div><div class='col-xs-2'><div class='spinner'></div></div><div class='col-xs-5'></div></div>");

    if (skip == 0 && $("#list-comment .comment").length > 0)
        skip = parseInt($("#list-comment .comment").length);

    $.ajax({
        url: ajax_get_comments,
        type: 'POST',
        dataType: 'json',
        data: {"_token": token, production_id: $("#production-id").val(), skip: skip},
        success: function (response) {

            $("#content-loader").remove();

            skip += response.length;
            for (var i = 0; i < response.length; i++) {

                if (total_comment == -1)
                    total_comment = response[i].total;

                if (total_comment == 0) {
                    $("#list-comment").html("<div id='content-not-comments'><div class='col-xs-3'></div><div class='col-xs-6 text-center'><h3><span class='glyphicon glyphicon-ban-circle'></span> <i>Sin comentarios aún. ¡Sé el primero!</i></h3></div><div class='col-xs-3'></div></div>");
                    skip = 0;
                    return;
                }


                var html = "<div class='comment'>" +
                        "<div class='col-xs-1 col-md-1'>" +
                        "<img class='avatar img-circle' src='" + response[i].avatar + "'> " +
                        "</div>" +
                        "<div class='col-xs-11'>" +
                        " <div class='col-xs-4' style='padding-left:0px;'>" + response[i].name + "</div>" +
                        " <div class='col-xs-8 text-right'>Hace " + response[i].date + "</div>" +
                        " <div class='comment-content'>" +
                        response[i].content +
                        " </div>" +
                        " </div>" +
                        "  </div>";

                $("#list-comment").append(html);
            }
        }
    });
}