
$(document).ready(function () {
    $(".production-index").click(function () {
        var url = url_site + $(this).attr("data-id");
        window.open(url, '_blank');
    });
    
    $("#add-new").click(function(){
      $("#modal-add").modal("show");  
    });
});
