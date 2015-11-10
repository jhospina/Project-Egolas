<?php

use App\System\Library\Complements\Util;
?>
@extends("manager/ui/templates/main")

@section("title") Dashboard @stop

@section("content")

<div class="col-xs-4 text-center stats">
    <h2><span class="glyphicon glyphicon-user"></span> Estado de usuarios</h2>
    <canvas id="chart-users-state" width="200" height="200"></canvas>
    <div class="text-left">
        <table class="table table-striped">
            <tr><th>Cuentas Sin Activar</th><td><?php echo $users_state[0]; ?></td></tr>
            <tr><th>Cuentas Activadas</th><td><?php echo $users_state[1]; ?></td></tr>
            <tr><th>Total usuarios</th><td><?php echo $users_state[0] + $users_state[1]; ?></td></tr>
        </table>
    </div>
</div>

<div class="col-xs-4 text-center stats">
    <h2><span class="glyphicon glyphicon-user"></span> Tipos de usuarios</h2>
    <canvas id="chart-users-role" width="200" height="200"></canvas>
    <div class="text-left">
        <table class="table table-striped">
            <tr><th>Usuarios gratis</th><td><?php echo $users_role[0]; ?></td></tr>
            <tr><th>Usuarios Premium</th><td><?php echo $users_role[1]; ?></td></tr>
            <tr><th>Total usuarios</th><td><?php echo $users_role[0] + $users_role[1]; ?></td></tr>
        </table>
    </div>
</div>

<div class="col-xs-4 text-center stats">
    <h2><span class="glyphicon glyphicon-film"></span> Producciones</h2>
    <canvas id="chart-productions" width="200" height="200"></canvas>
    <div class="text-left">
        <table class="table table-striped">
            <tr><th>Producciones Disponibles</th><td><?php echo $productions[0]; ?></td></tr>
            <tr><th>Producciones No Disponibles</th><td><?php echo $productions[1]; ?></td></tr>
            <tr><th>Total de producciones</th><td><?php echo $productions[0] + $productions[1]; ?></td></tr>
        </table>
    </div>
</div>

<div class="col-xs-3 text-center stats total">
    <h2><span class="glyphicon glyphicon-play-circle"></span> Reproducciones</h2>
    <div class="total-stats">{{$total_playbacks}}</div>
</div>
<div class="col-xs-3 text-center stats total">
    <h2><span class="glyphicon glyphicon-comment"></span> Comentarios</h2>
    <div class="total-stats">{{$total_comments}}</div>
</div>
<div class="col-xs-3 text-center stats total">
    <h2><span class="glyphicon glyphicon-heart"></span> Puntuaciones</h2>
    <div class="total-stats">{{$total_ratings}}</div>
</div>
<div class="col-xs-3 text-center stats total">
    <h2><span class="glyphicon glyphicon-credit-card"></span> Ingresos</h2>
    <div class="total-stats">{{$total_payments}} USD</div>
</div>


@stop

@section("script")

<script>
    var dataSetUsers_state = [{value:<?php echo $users_state[0]; ?>, color: "red", label: "Cuentas Sin Activar"}, {value:<?php echo $users_state[1]; ?>, color: "green", label: "Cuentas Activadas"}];
    var dataSetUsers_role = [{value:<?php echo $users_role[0]; ?>, color: "blue", label: "Usuarios gratis"}, {value:<?php echo $users_role[1]; ?>, color: "orange", label: "Usuarios Premium"}];
    var dataSetProductions = [{value:<?php echo $productions[0]; ?>, color: "green", label: "Disponibles"}, {value:<?php echo $productions[1]; ?>, color: "red", label: "No Disponibles"}];

</script>

<script src="{{URL::to("assets/plugins/chart/Chart.js")}}"></script>
<script src="{{URL::to("assets/scripts/manager/contents/dashboard.js")}}"></script>
@stop