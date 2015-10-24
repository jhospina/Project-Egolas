<p>Ya casi estas listo para comenzar ver peliculas gratis en la mejor calidad y completamente en español.</p>
<div class="col-lg-12 text-center"><img width='200px' src='{{URL::to("assets/images/email-send.png")}}'/></div>
<h2 class="text-center">Activa tu cuenta</h2>
<p>Te hemos enviado un mensaje a tu correo electrónico con un enlace para activar tu cuenta revísalo por favor. Si no vez ningún mensaje, revisa tu repositorio de correo no deseado.</p>
<p style="text-align: center;margin-bottom: 20px;margin-top: 20px;">
    <button id="btn-resend" class="btn btn-primary"><span class="glyphicon glyphicon-envelope"></span> ¿Reenviar enlace?</button>
</p>
<p>Al activar tu cuenta gratis podrás disfrutar de todos los beneficios de Bandicot.com:</p>
<h3>Beneficios de tu cuenta gratis:</h3>
<p> 
<ul>
    <li>Tienes derecho a reproducir un contenido enlazado(Pelicula) con Bandicot.com una unica vez por semana.</li>
    <li>Tienes derecho a comentar y dar a conocer tu opinión en relación a las producciones.</li>
    <li>Tienes derecho a puntuar tu satifacción por cualquiera de las producciones.</li>
    <li>Tienes derecho a navegar en todo el catalogo de producciones disponibles y no disponibles de momento.</li>
</ul>
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