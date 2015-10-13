var tooltip_template = '<div class="tooltip tooltip-error" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>';
var loaded = false;

$(document).ready(function () {
    $(".poster img").each(function () {
        $(this).load(function () {
            var parent = $(this).parent();
            $(parent.children(".spinner")).fadeOut();
            $(this).animate({"opacity": 1});
            loaded = true;
        });
    });

    //Verifica que las imagenes hallan sido cargadas
    setTimeout(function () {
            $(".poster img").each(function () {
                var parent = $(this).parent();
                $(parent.children(".spinner")).fadeOut();
                $(this).animate({"opacity": 1});
            });
    }, 2000);


    $("input").focus(function () {
        $(this).parent().parent().children(".tooltip").fadeOut(function () {
            $(this).remove()
        });
    });

    $("input").keypress(function () {
        $(this).parent().removeClass("has-error")
    });

});

function animLeft() {
    $("#background").animate({"left": "-" + Math.floor(Math.random() * 30) + "%", "top": "-" + Math.floor(Math.random() * 30) + "%"}, 30000, function () {
        animRight();
    });
}

function animRight() {
    $("#background").animate({"left": "-" + Math.floor(Math.random() * 30) + "%", "top": Math.floor(Math.random() * 30) + "%"}, 30000, function () {
        animLeft();
    });
}


function submit(btn) {
    var name = $("#name");
    var lastname = $("#lastname");
    var email = $("#email");
    var password = $("#password");
    var password_confirmation = $("#password_confirmation");
    if (name.val().length == 0) {
        jQuery(name.parent()).tooltip({placement: "left", trigger: "manual", title: "¿Cómo te llamas?", template: tooltip_template});
        jQuery(name.parent()).tooltip("show");
        jQuery(name.parent()).addClass("has-error");
        return;
    }

    if (lastname.val().length == 0) {
        jQuery(lastname.parent()).tooltip({placement: "bottom", trigger: "manual", title: "Tu apellido por favor", template: tooltip_template});
        jQuery(lastname.parent()).tooltip("show");
        jQuery(lastname.parent()).addClass("has-error");
        return;
    }

    if (!isEmail(email.val()))
    {
        jQuery(email.parent()).tooltip({
            placement: "left",
            trigger: "manual",
            title: "Necesitas un correo electrónico válido",
            template: tooltip_template});
        jQuery(email.parent()).tooltip("show");
        jQuery(email.parent()).addClass("has-error");
        return;
    }

    if (password.val().length < 6)
    {
        jQuery(password.parent()).tooltip({
            placement: "left",
            trigger: "manual",
            title: "Ingresa una contraseña mayor a 6 caracteres",
            template: tooltip_template});
        jQuery(password.parent()).tooltip("show");
        jQuery(password.parent()).addClass("has-error");
        return;
    }

    if (password.val().toString() != password_confirmation.val().toString())
    {
        jQuery(password_confirmation.parent()).tooltip({
            placement: "bottom",
            trigger: "manual",
            title: "Las contraseñas no coinciden",
            template: tooltip_template});
        jQuery(password_confirmation.parent()).tooltip("show");
        jQuery(password_confirmation.parent()).addClass("has-error");
        return;
    }

    $(btn).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Enviando...");
    $(btn).attr("disabled");
    $(btn).addClass("disabled");

    $("form").submit();

}
