
<div class="page-header">
    <h1 class="text-center"><span class="glyphicon glyphicon-alert"></span> Lo sentimos no puedes reproducir este contenido</h1>
</div>
<p class="caption text-center">Tú tipo de cuenta, no te permite reproducir más de un contenido por día y que ya hallas empezado a ver.</p>
<br/>
<div class="col-sm-6 text-center" style="padding-bottom: 20px;">
    <h3 class="text-center">Actualmente estabas viendo<br/>"{{$production->title}}"</h3>
    <div class="col-sm-12">
        <img width="214" height="317"  class="img-rounded" src="{{$production->image}}">
    </div>
    <div class="col-sm-12" style="margin-top: 10px;">
        <a href="{{URL::to('production/'.$production->slug."/play")}}" class="btn btn-lg btn-success"><span class="glyphicon glyphicon-play-circle"></span> Continuar viendo</a>
    </div>
</div>
<div class="col-sm-6 text-center" id="content-premium">
    <h2>¿Quieres ver todo lo que quieras sin limites?</h2>
    <p class="text-left">
        ¡Obtén una cuenta premium!
    </p>
    <ul class="text-left">
        <li><div>Reproduce y disfruta de todo el contenido disponible sin limitaciones ni restricciones.</div></li>
        <li><div>Accede a la funcionalidad de seguimiento de estrenos y de producciones aun no disponibles.</div></li>
        <li><div>Solicita producciones que desees ver y no encuentres en el catalogo.</div></li>
    </ul>
    <p class="text-center">
        <img style="width:130px;" src="{{URL::to("assets/images/logo-premium.png")}}"/><br/>
        <a href="{{URL::to("premium")}}" class="btn btn-lg btn-danger" style="margin-top: 20px;">¡Obtener una cuenta premium!</a>
    </p>
</div>