$(document).ready(function () {
    $("input").focus(function () {
        $(this).parent().parent().children(".tooltip").fadeOut(function () {
            $(this).remove()
        });
    });

    $("input").keypress(function () {
        $(this).parent().removeClass("has-error")
    });

});


function submit(btn) {

    if ($("#email").length > 0) {

        if ($("#email").val().length == 0) {
            jQuery($("#email").parent()).tooltip({placement: "left", trigger: "manual", title: "Introduce tu correo electrónico de acceso", template: tooltip_template});
            jQuery($("#email").parent()).tooltip("show");
            jQuery($("#email").parent()).addClass("has-error");
            return;
        }

        if (!isEmail($("#email").val())) {
            jQuery($("#email").parent()).tooltip({placement: "left", trigger: "manual", title: "El correo electrónico ingresado es invalido", template: tooltip_template});
            jQuery($("#email").parent()).tooltip("show");
            jQuery($("#email").parent()).addClass("has-error");
            return;
        }
    }

    if ($("#token").length > 0) {
        if ($("#token").val().length == 0)
        {
            jQuery($("#token").parent()).tooltip({placement: "left", trigger: "manual", title: "No has ingresado el código de seguridad", template: tooltip_template});
            jQuery($("#token").parent()).tooltip("show");
            jQuery($("#token").parent()).addClass("has-error");
            return;
        }
    }

    $(btn).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Enviando...");
    $(btn).attr("disabled");
    $(btn).addClass("disabled");

    $("form").submit();
}