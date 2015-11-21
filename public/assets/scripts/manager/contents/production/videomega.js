
$(document).ready(function () {

    $("#send").click(function () {
        var csv = $("#csv").val();

        $.ajax({
            url: ajax_link,
            type: 'POST',
            dataType: 'json',
            data: {"_token": token, csv: csv},
            success: function (response) {
             
                $("#links").html("");
                var num = 0;
                for (var i = 0; i < response.length; i++) {
                    var reg = response[i];
                       num++;
                    $("#links").append(reg.url + "<br/>");
                    if (num == 3) {
                        $("#links").append("<br/><br/>");
                        num = 0;
                    }
                    $("#info").append("<tr><td>" + reg.title + "</td><td>" + reg.title_md5 + "</td><td>" + reg.lote + "</td><td>" + reg.url + "</td></tr>");

                }
            },
            error: function (request, status, error) {
                $("#links").html("ERROR 503");
            }
        });
    });

})