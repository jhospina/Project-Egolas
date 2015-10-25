
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

//RATING
var rating = 0;
var rating_before = 0;
$(document).ready(function () {

    $("#content-bar .progress-bar").animate({"width": progress_rating}, 2000);

    $("#rating #content-bar .line img").hover(function () {
        $(this).animate({
            'margin-left': '-=2px',
            'margin-right': '+=2px'
        }, 50, function () {
            $(this).animate({
                'margin-left': '+=2px',
                'margin-right': '-=2px'
            }, 50, function () {
                //and so on...
            });
        });
    });


    $("#open-modal-rating-new").click(function () {
        $("#modal-rating").modal("show");
    });

    $("#modal-rating .rating-description").click(function () {
        $("#send-rating").removeAttr("disabled");
        $("#send-rating").removeClass("disabled");

        rating_before = rating;
        rating = parseInt($(this).parent().attr("data-rating"));
        $("#modal-rating img").addClass("inactive");
        $(this).parent().children("img").removeClass("inactive");
        animateBar();
    });

    $("#modal-rating .line img").click(function () {
        $("#send-rating").removeAttr("disabled");
        $("#send-rating").removeClass("disabled");

        rating_before = rating;
        rating = parseInt($(this).parent().attr("data-rating"));
        $("#modal-rating img").addClass("inactive");
        $(this).parent().children("img").removeClass("inactive");
        animateBar();
    });
});

function getColorBar(rating) {
    switch (parseInt(rating)) {
        case 1:
            return "rgb(255, 51, 0)";
        case 2:
            return "rgb(255, 102, 0)";
        case 3:
            return "rgb(255, 153, 0)";
        case 4:
            return "rgb(51, 204, 0)";
        case 5:
            return "rgb(0, 255, 0)";
    }
}

var progress = 0;

function animateBar() {

    var count = (rating > rating_before) ? 1 : -1;
    var f = 0;
    for (var i = rating_before; i != rating; i = i + count) {
        f++;
        setTimeout(function () {
            progress += 20 * count;
            $("#modal-rating .progress-bar").css("background", getColorBar(progress / 20));
            $("#modal-rating .progress-bar").animate({"height": progress + "%"}, 200);
        }, f * 198);
    }
}


$(document).ready(function () {
    $("#send-rating").click(function () {

        $(this).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Enviando...");
        $(this).attr("disabled");
        $(this).addClass("disabled");


        $.ajax({
            url: ajax_post_rating,
            type: 'POST',
            dataType: 'json',
            data: {"_token": token, production_id: $("#production-id").val(), rating: rating},
            success: function (response) {
                $("#modal-rating .modal-body").html("<div class='text-center'><h3>Tu opinión ha sido recibida.</h3><h3>¡Muchas gracias!</h3><h3 class='glyphicon glyphicon-thumbs-up'></h3></div>");
                $("#send-rating").html("...");
                $("#send-rating").removeAttr("disabled");
                $("#send-rating").removeClass("disabled");
                $("#modal-rating .modal-footer").remove();
                setTimeout(function () {
                    $("#modal-rating").modal("hide");
                    location.reload();
                }, 3000);
            }
        });

    });
});

//FAVORITES
$(document).ready(function () {
    $("#content-add-favorite").mouseover(function () {
        $(this).css("opacity", 1);
    });

    $("#content-add-favorite").mouseout(function () {
        if ($(this).attr("data-flag") != "sending")
            $(this).css("opacity", 0);
    });
    $("#content-add-favorite").click(function () {
        $("#content-add-favorite").unbind("click");
        $(this).css("opacity", 1);
        $(this).attr("data-flag", "sending");
        $(this).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span><label>Agregando a tu lista...</label>");

        $.ajax({
            url: ajax_post_favorites,
            type: 'POST',
            dataType: 'json',
            data: {"_token": token, production_id: $("#production-id").val()},
            success: function (response) {
                if (response == "true") {
                    $("#content-add-favorite").html("<span style='color:green;' class='glyphicon glyphicon-ok'></span><label>Agregando a favoritos</label>");
                    setTimeout(function () {
                        $("#content-add-favorite").remove();
                        $("#poster").append("<div id='inFav' title='En favoritos'><span class='glyphicon glyphicon-star'></span></div>");
                    }, 3000);
                }
            }
        });
    });
});