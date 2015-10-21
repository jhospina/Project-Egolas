
$(document).ready(function () {

    $("input").focus(function () {
        $(this).parent().parent().children(".tooltip").fadeOut(function () {
            $(this).remove()
        });
    });

    $("input").keypress(function () {
        $(this).parent().removeClass("has-error")
    });

    $("#btn-submit").click(function () {
        if ($("#day option:selected").val() != "none" && $("#month option:selected").val() != "none" && $("#year option:selected").val() != "none")
            $("#birth").val($("#year option:selected").text() + "-" + $("#month option:selected").text() + "-" + $("#day option:selected").text());

        $(this).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Guardando...");
        $(this).attr("disabled");
        $(this).addClass("disabled");
        $("#form").submit();
    });


    $("#btn-submit-pass").click(function () {

        if ($("#current-pass").val().length == 0) {
            jQuery($("#current-pass").parent()).tooltip({placement: "left", trigger: "manual", title: "Introduce tu actual contraseña para verificar tu identidad", template: tooltip_template});
            jQuery($("#current-pass").parent()).tooltip("show");
            jQuery($("#current-pass").parent()).addClass("has-error");
            return;
        }


        if ($("#new-pass").val().length < 6) {
            jQuery($("#new-pass").parent()).tooltip({placement: "left", trigger: "manual", title: "Necesitas una contraseña de más de 6 caracteres", template: tooltip_template});
            jQuery($("#new-pass").parent()).tooltip("show");
            jQuery($("#new-pass").parent()).addClass("has-error");
            return;
        }

        if ($("#new-pass").val() != $("#new-pass-rep").val()) {
            jQuery($("#new-pass-rep").parent()).tooltip({placement: "left", trigger: "manual", title: "Las contraseñas no coinciden", template: tooltip_template});
            jQuery($("#new-pass-rep").parent()).tooltip("show");
            jQuery($("#new-pass-rep").parent()).addClass("has-error");
            return;
        }


        $(this).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Estableciento...");
        $(this).attr("disabled");
        $(this).addClass("disabled");
        $("#form-pass").submit();
    });
});