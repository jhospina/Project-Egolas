var response_request = $("#response-request");
var send = $("#send");

$(document).ready(function () {

    $("#open-modal-request").click(function () {
         $("#modal-request").modal("show");
    });

    $("#send").click(function () {

        var btn = this;
        response_request.hide();

        var url = $("#link-imdb").val();
        $("#link-imdb").attr("disabled", "disabled");
        setLoadingButton(btn, "Validando...");
        setTimeout(function () {
            /*VALIDAL A URL*/
            if (isUrl_IMDB(url))
            {
                setLoadingButton(btn, "Cargando...");


                /*PETICICION AJAX*/
                $.ajax({
                    url: ajax_request,
                    type: 'POST',
                    dataType: 'json',
                    data: {"_token": token, url: url},
                    success: function (response) {

                        if (response.error) {
                            setError(response.error);
                            return;
                        }

                        var state = response.state;
                        if (state == "active") {
                            $("#instructions").fadeOut(function () {
                                responseActive(response);
                                setLoadingButton(btn, "Esperando...");
                            });

                        }

                        if (state == "inwait") {
                            $("#instructions").fadeOut(function () {
                                responseInWait(response);
                                setLoadingButton(btn, "Esperando...");
                            });
                        }

                        if (state == "inqueue") {
                            $("#instructions").fadeOut(function () {
                                responseInQueue(response);
                                setLoadingButton(btn, "Esperando...");
                            });
                        }

                        if (state == "addqueue") {
                            $("#instructions").fadeOut(function () {
                                responseAddQueue(response);
                                setLoadingButton(btn, "Esperando...");
                            });
                        }
                    }, error: function (request, status, error) {
                        setError("Ha ocurrido un problema al procesar este enlace. Intentalo de nuevo. Si el problema persiste por favor informanos.");
                    }
                });

            } else {
                setError("Este enlace de producción de IMDB no es válida.");
            }
        }, 1000);

    });

    $("#cancel").click(function () {
        $("#result").fadeOut(function () {
            $("#instructions").fadeIn();
            setDefaultButton($("#send"), "Enviar");
            $("#link-imdb").removeAttr("disabled");
            $("#link-imdb").val("");
        });

        if ($("#instructions").css("display") == "none")
            location.reload();
    });

});


function responseActive(response) {
    var html = "<div class='text-center'>" +
            "<h2>¡Esta producción ya se encuentra disponible!</h2>" +
            "<div id='production-response'><h3>" + response.title + "<br/><small>" + response.title_original + "</small></h3>" +
            "<a target='_blank' href='" + response.link + "'><img class='img-rounded' src='" + response.image + "'/></a>" +
            "</div>" +
            "<div class='reset text-center'><button id='reset-instructions' class='btn btn-danger'>¿Intentarlo de nuevo?</button></div>"
    "</div>";
    $("#result").html(html).fadeIn();
    setHandlerReset();
}

function responseInWait(response) {
    var html = "<div class='text-center'>" +
            "<h2>¡Solicitud realizada con éxito!</h2>" +
            "<p class='caption'>Aunque tu producción ya había sido procesada anteriormente y estaba en espera por obtener una fuente de vídeo por parte de nuestro sistema. Tu solicitud ha sido aceptada y ayudara a que nuestro rastreador priorice tu producción para ponerla en disponibilidad para ser reproducida, cuando esto se logre, te avisaremos.</p>"
            + "<div id='production-response'><h3>" + response.title + "<br/><small>" + response.title_original + "</small></h3>" +
            "<a target='_blank' href='" + response.link + "'><img class='img-rounded' src='" + response.image + "'/></a>" +
            "</div>" +
            "<div class='reset text-center'><button id='reset-instructions' class='btn btn-danger'>¿Realizar otra solicitud?</button></div>"
    "</div>";
    $("#result").html(html).fadeIn();
    setHandlerReset();
}

function responseInQueue(response) {
    var html = "<div class='text-center'>" +
            "<h2>¡Solicitud realizada con éxito!</h2>" +
            "<p class='caption'>Esta producción se encuentra en cola procesamiento para la recopilación de datos. Aún esta en una etapa temprana para estar disponible en nuestro catalogo, pero tu solicitud priorizara esta producción en la cola para que sea procesada en el menor tiempo si es posible. Cuando este disponible para su reproducción te avisaremos.</p>"
            + "<div id='production-response'><h3>" + response.title + "</h3>" +
            "</div>" +
            "<div class='reset text-center'><button id='reset-instructions' class='btn btn-danger'>¿Realizar otra solicitud?</button></div>"
    "</div>";
    $("#result").html(html).fadeIn();
    setHandlerReset();
}

function responseAddQueue(response) {
    var html = "<div class='text-center'>" +
            "<h2>¡Solicitud realizada con éxito!</h2>" +
            "<p class='caption'>Tu producción ha sido agregada a la cola de procesamiento de nuestro sistema. En esta cola se recopila su información y despues el sistema se encargara de buscar una fuente de video en la internet. Tu solicitud priorizara esta producción en la cola para que sea procesada en el menor tiempo si es posible. Cuando este disponible para su reproducción te avisaremos.</p>"
            + "<div id='production-response'><h3>" + response.title + "</h3>" +
            "</div>" +
            "<div class='reset text-center'><button id='reset-instructions' class='btn btn-danger'>¿Realizar otra solicitud?</button></div>"
    "</div>";
    $("#result").html(html).fadeIn();
    setHandlerReset();
}



function setError(text) {
    response_request.show();
    response_request.html("<span class='glyphicon glyphicon-remove-sign'></span> " + text);
    setDefaultButton(send, "Enviar");
    $("#link-imdb").removeAttr("disabled");
    $("#link-imdb").val("");
}

function setHandlerReset() {
    $("#reset-instructions").click(function () {
        $("#result").fadeOut(function () {
            $("#instructions").fadeIn();
            setDefaultButton($("#send"), "Enviar");
            $("#link-imdb").removeAttr("disabled");
            $("#link-imdb").val("");
        });
    });
}


function setDefaultButton(btn, text) {
    $(btn).html(text).removeAttr("disabled").removeClass("disabled");
}

function setLoadingButton(btn, text) {
    $(btn).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> " + text).attr("disabled");
    $(btn).addClass("disabled");
}


function isUrl_IMDB(str) {
    var valid = true;
    var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
    if (!regexp.test(str))
        valid = false;
    if (!/\/www.imdb.com\/title\//.test(str))
        valid = false;
    return valid;
}