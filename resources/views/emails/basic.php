<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <p>Hola, <?php print($name); ?>:</p>
    <?php print($description); ?>
    <hr>
    <i>
        Te enviamos este email como parte de tu suscripción en <span class="il">Bandicot.com</span>. No respondas a este email, ya que no podemos contestarte desde esta dirección.<br/>
        Este mensaje se envió a&nbsp;[<a style="color: #C52C2C;" href="mailto:<?php print($email); ?>" target="_blank"><?php print($email); ?></a>]&nbsp;de parte de <span class="il">Bandicot.com</span>.<br/>
        El uso del servicio y del sitio web de <span class="il">Bandicot</span> está sujeto a nuestros <a style="color: #FF0000;" href="https://bandicot.com/doc/terms" target="_blank">Términos y condiciones</a> y a nuestra <a style="color: #FF0000;" href="https://bandicot.com/doc/privacypolicy" target="_blank">Politica de privacidad</a>.<br/>
    </i>
</body>
</html>