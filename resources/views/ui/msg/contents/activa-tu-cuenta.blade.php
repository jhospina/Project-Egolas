
<div class="col-lg-12 text-center"><img width='200px' src='{{URL::to("assets/images/email-send.png")}}'/></div>
<h2 class="text-center">Para reproducir los contenidos en bandicot.com es necesario que actives tu cuenta</h2>
<p>Para activar tu cuenta debes de confirmar tu correo electrónico, para ello debes revisar tu correo e ingresa al enlace que te enviamos. Si no ves el correo de bandicot, revisa tu repositorio de correo no deseado o de spam.</p>
<p style="text-align: center;margin-bottom: 20px;margin-top: 20px;">
    <button id="btn-resend" class="btn btn-primary"><span class="glyphicon glyphicon-envelope"></span> ¿Reenviar enlace?</button>
</p>


<script>
    $("#btn-resend").click(function () {

        $(this).html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Enviando...");
        $(this).attr("disabled");
        $(this).addClass("disabled");

        $.ajax({
            url: "{{URL::to('user/account/ajax/send/email/confirmation')}}",
            type: 'POST',
            dataType: 'json',
            data: {"_token": "{{Session::token()}}"},
            success: function (response) {
                $("#btn-resend").html("<span class='glyphicon glyphicon-ok'></span> ¡Enlace enviado!");
                $("#btn-resend").removeClass("btn-primary");
                $("#btn-resend").addClass("btn-success");
            }
        });
    });
</script>