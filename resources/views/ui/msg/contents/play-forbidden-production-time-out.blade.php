<?php

use App\System\Library\Complements\DateUtil;

$date = new DateUtil(DateUtil::getCurrentTime());
//Calcula el tiempo restante para que el usuario pueda ver otra pelicula
$coming_date = $date->addSeconds((60 * 60 * 24) - $time);
?>


<div class="page-header text-center">
    <h1>Haz alcanzado el número máximo de reproducciones para tu cuenta</h1>
</div>
<h2 class="text-center">Puedes reproducir otro contenido en...</h2>
<ul id="countdown">
    <li> <span class="days">00</span>
        <p class="timeRefDays">Días</p>
    </li>
    <li> <span class="hours">00</span>
        <p class="timeRefHours">Horas</p>
    </li>
    <li> <span class="minutes">00</span>
        <p class="timeRefMinutes">Minutos</p>
    </li>
    <li> <span class="seconds">00</span>
        <p class="timeRefSeconds">Segundos</p>
    </li>
</ul>

<div class="col-lg-12" style="padding: 0px;">
    <h1>¿No quieres esperar? ¡Obtén una cuenta premium!</h1>
    <ul class="text-left" style="font-size: 13pt;padding: 0px;">
        <li><div>Reproduce y disfruta de todo el contenido disponible sin limitaciones ni restricciones.</div></li>
        <li><div>Accede a la funcionalidad de seguimiento de estrenos y de producciones aun no disponibles.</div></li>
        <li><div>Solicita producciones que desees ver y no encuentres en el catalogo.</div></li>
    </ul>
    <p class="text-center">
        <img style="width:130px;" src="{{URL::to("assets/images/logo-premium.png")}}"/><br/>
        <a href="{{URL::to("premium")}}" class="btn btn-lg btn-danger" style="margin-top: 20px;">¡Obtener una cuenta premium!</a>
    </p>
</div>

<script>

    $(document).ready(function () {
        $("#countdown").countdown({
            date: "{{$coming_date}}",
            format: "on"
        },
        function () {
// callback function
        });
    });

</script>
