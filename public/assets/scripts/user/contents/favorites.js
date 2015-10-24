$(document).ready(function () {
    $("#favorites .production").click(function () {
        window.open(url_site + "/production/" + $(this).attr("data-slug"),"_blank");
    });

    $("#favorites .production").mouseover(function () {
        $(this).children(".information").css("opacity", 1);
    });

    $("#favorites .production").mouseout(function () {
        $(this).children(".information").css("opacity", 0);
    });
});