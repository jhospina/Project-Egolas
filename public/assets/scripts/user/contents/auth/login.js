$(function () {
    if($('.button-checkbox').length==0)
        return;
    $('.button-checkbox').each(function () {
        var $widget = $(this),
                $button = $widget.find('button'),
                $checkbox = $widget.find('input:checkbox'),
                color = $button.data('color'),
                settings = {
                    on: {
                        icon: 'glyphicon glyphicon-check'
                    },
                    off: {
                        icon: 'glyphicon glyphicon-unchecked'
                    }
                };

        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });

        $checkbox.on('change', function () {
            updateDisplay();
        });

        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');
            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                    .removeClass()
                    .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                        .removeClass('btn-default')
                        .addClass('btn-' + color + ' active');
            }
            else
            {
                $button
                        .removeClass('btn-' + color + ' active')
                        .addClass('btn-default');
            }
        }
        function init() {
            updateDisplay();
            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
});


$(document).ready(function () {
    $("input").focus(function () {
        $(this).parent().parent().children(".tooltip").fadeOut(function () {
            $(this).remove()
        });
    });

    $("input").keypress(function () {
        $(this).parent().removeClass("has-error")
    });
    
     $('#password').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            submit($("#submit"));
        }
    });

});


function submit(btn) {
    if ($("#email").val().length == 0) {
        jQuery($("#email").parent()).tooltip({placement: (isMobile())?"top":"left", trigger: "manual", title: "Introduce tu correo electrónico de acceso", template: tooltip_template});
        jQuery($("#email").parent()).tooltip("show");
        jQuery($("#email").parent()).addClass("has-error");
        return;
    }

    if (!isEmail($("#email").val())) {
        jQuery($("#email").parent()).tooltip({placement: (isMobile())?"top":"left", trigger: "manual", title: "El correo electrónico ingresado es invalido", template: tooltip_template});
        jQuery($("#email").parent()).tooltip("show");
        jQuery($("#email").parent()).addClass("has-error");
        return;
    }

    $(btn).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Enviando...");
    $(btn).attr("disabled");
    $(btn).addClass("disabled");

    $("form").submit();
}