
$(document).ready(function () {

    $("#btn-submit").click(function () {
        if ($("#day option:selected").val() != "none" && $("#month option:selected").val() != "none" && $("#year option:selected").val() != "none")
            $("#birth").val($("#year option:selected").text() + "-" + $("#month option:selected").text() + "-" + $("#day option:selected").text());
        
        $(this).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Guardando...");
        $(this).attr("disabled");
        $(this).addClass("disabled");
        $("#form").submit();
    });
});