/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {


    $("#submit-btn").click(function () {


        $(this).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Enviando información...");
        $(this).attr("disabled");
        $(this).addClass("disabled");

        var error = false;
        if ($("#type option:selected").val() == 0) {
            $("#response-error").html("<span class='glyphicon glyphicon-alert'></span> Debes indicar cual es el problema");
            $("#type").focus();
            error = true;
        }

        if ($("#description").val().length < 10) {
            $("#response-error").html("<span class='glyphicon glyphicon-alert'></span> Debes proporcionarnos detalles del problema.");
            $("#description").focus();
            error = true;
        }

        if (error) {
            $("#response-error").show();
            $(this).html("Enviar información");
            $(this).removeAttr("disabled");
            $(this).removeClass("disabled");
        }
        else {
            $("#form-report").submit();
        }
    });

});