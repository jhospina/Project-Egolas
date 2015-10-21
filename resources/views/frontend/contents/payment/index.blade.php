<?php ?>

@extends("frontend/templates/gen",array("id_body"=>"payment-index"))

@section("title") ¡Obtén una cuenta premium! @stop

@section("css")
{{ HTML::style('assets/css/frontend/payment.css', array('media' => 'screen')) }}
@stop

@section("content")

<div class="text-center container content">
    <div class="jumbotron text-center">
        <h1>¡Obtén una cuenta premium y disfruta sin limites!</h1>
        <p class="resalt">Para mantener nuestra plataforma libre de publicidad y para el sostenimiento de nuestros servidores, te pedimos que contribuyas con nosotros dejandonos 
            tu aporte, solo te pedimos una donación de {{trans("gen.price.cuant")}} USD y nosotros te daremos una cuenta premium por dos meses como recompensa por tu contribución.</p>
    </div>
    <img src="{{URL::to("assets/images/logo-premium.png")}}">
    <div class="jumbotron text-center">
        <h1>¡Disfruta de 2 meses sin limites por solo {{trans("gen.price.cuant")}} USD!</h1>
        <h3 class="text-left">Beneficios de una cuenta premium:</h3>
        <p>
        <ul>
            <li>Reproduce y disfrutar de todo el contenido de producciones disponible sin limitaciones.</li>
            <li>Accede a la funcionalidad de seguimiento de estrenos y de producciones aun no disponibles.</li>
            <li>Influye en la cola de procesamiento para la inclusión de nuevas producciones al catalogo.</li>
        </ul>
        </p>
    </div>
    <div class="page-header" style="color:black;">
        <h1>Metodos de pago</h1>
    </div>
    <form id="form" action="{{URL::to('premium/payment/post')}}" method="POST">
        {{ csrf_field() }}
        <div id="btn-pay" class="btn btn-primary">
            <section><span class="glyphicon glyphicon-credit-card"></span> Pagar con</section>
            <img src="{{URL::to('assets/images/paypal.jpg')}}"/>
        </div>
    </form>
</form>
</div>

@stop

@section("script")

<script>
    $(document).ready(function () {
        $("#btn-pay").click(function () {
            $("#btn-pay section").html("<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Espera...");
            $(this).attr("disabled");
            $(this).addClass("disabled");
            $("#form").submit();
        });
    });
</script>

@stop