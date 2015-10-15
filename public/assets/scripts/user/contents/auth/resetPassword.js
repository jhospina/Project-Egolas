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

    if ($("#pass").val().length == 0) {
        jQuery($("#pass").parent()).tooltip({placement: "left", trigger: "manual", title: "Debes escribir una contraseña", template: tooltip_template});
        jQuery($("#pass").parent()).tooltip("show");
        jQuery($("#pass").parent()).addClass("has-error");
        return;
    }

    if ($("#pass").val() != $("#pass-rep").val()) {
        jQuery($("#pass-rep").parent()).tooltip({placement: "left", trigger: "manual", title: "Las contraseñas no coinciden", template: tooltip_template});
        jQuery($("#pass-rep").parent()).tooltip("show");
        jQuery($("#pass-rep").parent()).addClass("has-error");
        return;
    }

    $(btn).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Enviando...");
    $(btn).attr("disabled");
    $(btn).addClass("disabled");

    $("form").submit();
}