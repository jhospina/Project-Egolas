$(document).ready(function () {
    $("#content-avatar").mouseover(function () {
        $("#action-edit-avatar").addClass("hover");
        $("#action-edit-avatar label").show();
    });
    $("#content-avatar").mouseout(function () {
        $("#action-edit-avatar").removeClass("hover");
        $("#action-edit-avatar label").hide();
    });


    $("#content-avatar").click(function () {
        $("#modal-avatar").modal("show");
    });

});

$(document).ready(function () {

    $("#upload-avatar").fileinput({
        multiple: false,
        showPreview: true,
        showRemove: false,
        showUpload: false,
        initialPreview: false,
        maxFileCount: 1,
        previewFileType: "image",
        allowedFileExtensions: ['jpg', 'png'],
        browseLabel: "Buscar foto",
        browseIcon: '<i class="glyphicon glyphicon-picture"></i> ',
        removeClass: "btn btn-danger",
        removeLabel: "Borrar",
        removeIcon: '<i class="glyphicon glyphicon-trash"></i> ',
        uploadClass: "btn btn-info",
        uploadExtraData: {"_token": token_ajax},
        dropZoneEnabled: true,
        dropZoneTitle: "Arrastra tu imagen de perfil aquí...",
        uploadIcon: '<i class="glyphicon glyphicon-upload"></i> ',
        msgSelected: "{n} Imagen",
        maxFileSize: 2000,
        msgInvalidFileExtension: "El archivo que has escogido no es valido. Solo se permiten imagenes en formatos {extensions}.",
        msgInvalidFileType: "El archivo que has escogido no es valido. Solo se permiten imagenes en formatos {extensions}.",
        msgSizeTooLarge: "El tamaño de la imagen es demasiado grande. Maximo <b>{maxSize} KB</b>. Esta imagen pesa <b>{size} KB.",
        uploadAsync: true,
        uploadUrl: url_ajax_upload_avatar // your upload server url
    });


    $('#upload-avatar').on('fileuploaded', function (event, data, previewId, index) {
        var response = data.response;
        $("#modal-avatar").modal("hide");
          $('#upload-avatar').fileinput('reset');
        $("#avatar img").attr("src", response.url);
    });

    //Sube la imagen una vez seleccionada
    $('#upload-avatar').on('fileimageloaded', function (event, previewId) {
        $("#msg-error-upload-avatar").hide();
        $('#upload-avatar').fileinput('upload');
    });

    $('#upload-avatar').on('fileuploaderror', function (event, data) {
        $("#msg-error-upload-avatar").html(strip_tags($(".file-error-message").html()));
        $("#msg-error-upload-avatar").show();
        $('#upload-avatar').fileinput('reset');
    });

});





function strip_tags(input, allowed) {
    //  discuss at: http://phpjs.org/functions/strip_tags/
    // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Luke Godfrey
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    //    input by: Pul
    //    input by: Alex
    //    input by: Marc Palau
    //    input by: Brett Zamir (http://brett-zamir.me)
    //    input by: Bobby Drake
    //    input by: Evertjan Garretsen
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Onno Marsman
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Eric Nagel
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Tomasz Wesolowski
    //  revised by: Rafał Kukawski (http://blog.kukawski.pl/)
    //   example 1: strip_tags('<p>Kevin</p> <br /><b>van</b> <i>Zonneveld</i>', '<i><b>');
    //   returns 1: 'Kevin <b>van</b> <i>Zonneveld</i>'
    //   example 2: strip_tags('<p>Kevin <img src="someimage.png" onmouseover="someFunction()">van <i>Zonneveld</i></p>', '<p>');
    //   returns 2: '<p>Kevin van Zonneveld</p>'
    //   example 3: strip_tags("<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>", "<a>");
    //   returns 3: "<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>"
    //   example 4: strip_tags('1 < 5 5 > 1');
    //   returns 4: '1 < 5 5 > 1'
    //   example 5: strip_tags('1 <br/> 1');
    //   returns 5: '1  1'
    //   example 6: strip_tags('1 <br/> 1', '<br>');
    //   returns 6: '1 <br/> 1'
    //   example 7: strip_tags('1 <br/> 1', '<br><br/>');
    //   returns 7: '1 <br/> 1'

    allowed = (((allowed || '') + '')
            .toLowerCase()
            .match(/<[a-z][a-z0-9]*>/g) || [])
            .join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
            commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
    return input.replace(commentsAndPhpTags, '')
            .replace(tags, function ($0, $1) {
                return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
            });
}