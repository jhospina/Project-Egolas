@extends("ui/templates/land")


@section("content")

<nav class="navbar navbar-inverse" id="navbar">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{URL::to("")}}">
            <img class="img-rounded" style="width: 250px;height:58px;" id="logo-okonexion" src="{{URL::to("assets/images/logo.png")}}">
        </a>
    </div>
    <div>

    </div>
</nav>

<div id="background">
    @foreach($productions as $production)
    <div class="poster">
        <img src="{{$production->image}}" border="0">
        <div class="spinner"></div>
    </div>
    @endforeach
</div>

<div id="overligth">
</div>

<div id="content-main">

    <div class="col-lg-6">

        <div class="jumbotron" style="background: none;">
            <h1>¡Disfruta del mejor catalogo de peliculas gratis en internet!</h1>
            <p>
            <ul>
                <li>Peliculas en alta definición (HD)</li>
                <li>La mejor selección para tus gustos</li>
                <li>El mejor contenido en español</li>
                <li>Hazle seguimiento a los proximos estrenos</li>
                <li>Entarate cuando tus peliculas favoritas esten disponibles</li>
                <li>Sin publicidad molesta</li>
            </ul>
            </p>
            <p><a class="btn btn-danger btn-lg" href="#" role="button"><span class="glyphicon glyphicon-th"></span> Ver catalogo</a></p>
        </div>

    </div>
    <div class="col-lg-6">

        <div class="row">
            <div id="content-form" class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <form role="form">
                    <h2 class="text-center">¡Crear tu cuenta gratis!</h2>
                    <hr class="colorgraph">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="first_name" id="first_name" class="form-control input-lg" placeholder="Nombre" tabindex="1">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="last_name" id="last_name" class="form-control input-lg" placeholder="Apellido" tabindex="2">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Correo electrónico" tabindex="4">
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Contraseña" tabindex="5">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg" placeholder="Confirmar Contraseña" tabindex="6">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            Al hacer clic en el botón <i>"Registrarme"</i>, tu aceptas haber leido y aceptado los <a href="#" data-toggle="modal" data-target="#t_and_c_m">Terminos y condiciones</a> para el uso de nuestro sitio web.
                        </div>
                    </div>

                    <hr class="colorgraph">
                    <div class="row">
                        <div class="col-xs-12 col-md-12"><input type="submit" value="Registrarme" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
                    </div>
                </form>
            </div>
        </div>

    </div>


</div>


<!-- Modal -->
<div class="modal fade"  id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="color:black;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Terminos y condiciones</h4>
			</div>
			<div class="modal-body">
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop

@section("script")
<script>
    $(document).ready(function () {
        $(".poster img").each(function () {
            $(this).load(function () {
                var parent = $(this).parent();
                $(parent.children(".spinner")).fadeOut();
                $(this).animate({"opacity": 1});
            });
        });

        //animLeft();
    });

    function animLeft() {
        $("#background").animate({"left": "-" + Math.floor(Math.random() * 30) + "%", "top": "-" + Math.floor(Math.random() * 30) + "%"}, 30000, function () {
            animRight();
        });
    }

    function animRight() {
        $("#background").animate({"left": "-" + Math.floor(Math.random() * 30) + "%", "top": Math.floor(Math.random() * 30) + "%"}, 30000, function () {
            animLeft();
        });
    }
</script>
@stop