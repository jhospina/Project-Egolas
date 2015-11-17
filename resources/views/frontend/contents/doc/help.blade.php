@extends("frontend/templates/gen")

@section("title"){{trans("gen.doc.help")}}@stop

@section("content")

<div class="content container desk">
    <div class="jumbotron">
        <h1><span class="glyphicon glyphicon-exclamation-sign"></span> {{trans("gen.doc.help")}}</h1>
        <p>Si tienes dudas o inquietudes acerca de nuestro servicio, envianos un mensaje al correo electrónico <i><b>{{trans("gen.email.support")}}</b></i> y con gusto atenderemos tus dudas.</p>
        <h2 style="margin-top:50px;"><span class="glyphicon glyphicon-question-sign"></span> Preguntas Frecuentes</h2>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            ¿Quiero ver una película pero porque no me reproduce?
                        </a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        El uso de los servicios de bandicot esta pensado para los navegadores de internet más modernos, en donde se implementa la tecnología de HTML5, ya que esta permite la visualización en los diferentes dispositivos móviles actuales. La reproducción de los contenidos audiovisuales solamente se hacen bajo esta tecnología, por lo que si tu navegador no lo reproduce tendrás que actualizarlo.
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading2">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            ¿Puedo usar mi celular o tableta para navegar o ver las películas?

                        </a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                    <div class="panel-body">
                        Si. Nuestra plataforma ha sido diseñada para que los usuarios puedan ingresar desde cualquier dispositivo que soporte HTML5. Así que si dispones de un celular o tablet con Android, IOS o Windows Phone de los últimos años, podrás navegar y reproducir los contenidos de bandicot sin ningún problema. </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading7">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse7" aria-expanded="false" aria-controls="collapse7">
                            ¿Por que las peliculas no son en Alta Calidad?
                        </a>
                    </h4>
                </div>
                <div id="collapse7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading7">
                    <div class="panel-body">
                        Las películas que puedes encontrar en bandicot no son en alta calidad por que este formato no es el que abunda en Internet. Nuestro sistema utiliza algoritmos de análisis y rastreo que estudian y verifican las propiedades de vídeo de las películas que se encuentran en Internet para enlazarse con ellas y transmitirlas a través del reproductor de bandicot con las características deseadas. Debido a esto y a que deseamos disponer del mejor catalogo de películas, estas deberán ser en formato DVD, pero eso no quiere decir que en un futuro no puedan ser en HD.   </div>
                </div>
            </div>
                        <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading5">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            ¿Puedo obtener un reembolso del dinero que pague por una cuenta premium?
                        </a>
                    </h4>
                </div>
                <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                    <div class="panel-body">
                        Si. Puedes obtener un reembolso del dinero que pagaste, pero solamente dentro los 72 horas siguientes de haber realizado el pago. Para ello debes escribir un un mensaje al correo electrónico <b>{{trans("gen.email.support")}}</b> indicando el correo electrónico de tu cuenta de bandicot y la secuencia de identificación de la transacción realizada que puedes encontrar como <i>"Transacción ID"</i> en la sección de <a href="{{URL::to('user/contributions')}}">Contribuciones</a> de tu cuenta. Debes indicar en el asunto del correo <i>"Reembolso"</i> para poder responderte lo antes posible. Si las condiciones se cumplen correctamente en un máximo de 24 horas hábiles se realizara la solicitud de reembolso a tu cuenta de Paypal. Después de haberse realizado la solicitud, Paypal te reembolsara el dinero en un máximo de 5 días hábiles.
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading8">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse8" aria-expanded="false" aria-controls="collapse8">
                            ¿Por que la portada de algunas películas se muestran en blanco y negro?
                        </a>
                    </h4>
                </div>
                <div id="collapse8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading8">
                    <div class="panel-body">
                        Las portadas de muchas películas que puedas encontrar en bandicot se mostraran en blanco y negro porque aun no se encuentran disponibles para ser reproducidas. Esto debido a que su base de información ya fue adquirida pero nuestro algoritmo de rastreo aún no ha dado con una fuente de vídeo en la Internet para poder transmitirla. 
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading9">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse9" aria-expanded="false" aria-controls="collapse9">
                            ¿Por que el nombre o la descripción de algunas películas están en ingles, mal escritas o con errores de redacción?
                        </a>
                    </h4>
                </div>
                <div id="collapse9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9">
                    <div class="panel-body">
                        Esto es algo frecuente, debido a que el algoritmo que rastrea y capta información de la internet es un robot que no puede determinar la gramática concisa del idioma español y a su vez al captar los datos que pueden estar en el idioma ingles trata de buscar su traducción y al no encontrarla la dejara tal cual. Pero nuestro equipo de trabajo revisa regularme la información de las peliculas para corregir la información y escribirla correctamente.
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading10">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse10" aria-expanded="false" aria-controls="collapse10">
                            ¿Por que solamente puedo reproducir una película una vez a la semana?
                        </a>
                    </h4>
                </div>
                <div id="collapse10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading10">
                    <div class="panel-body">
                        Debido a que el uso de nuestros recursos de servidor son altamente costosos no podemos ofrecer un servicio totalmente gratuito, así que debemos limitar la reproducción de las películas una única vez por semana a los usuarios gratuitos. De todas maneras la adquisición de una cuenta premium la hemos establecido aún bajo costo para que cualquiera pueda adquirirla. 
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading3">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            ¿Como puedo agregar a mi lista de favoritos una película?
                        </a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                    <div class="panel-body">
                        Para agregar a tu lista de favoritos una pelicula, solo debes pulsar encima de la imagen de su portada en su sección informativa.
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading4">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            ¿Cómo puedo eliminar de mi lista de favoritos una película?
                        </a>
                    </h4>
                </div>
                <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                    <div class="panel-body">
                        La unica manera de hacerlo es ir a la sección de <a href="{{URL::to('user/favorites')}}">favoritos</a> de tu cuenta y eliminarla desde allí.
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stop