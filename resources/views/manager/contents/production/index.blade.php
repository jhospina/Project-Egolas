<?php

use App\System\Library\Complements\Util;
use App\System\Models\Production;
?>
@extends("manager/ui/templates/main",array("path"=>"manager/contents/production/index"))

@section("title") {{trans("ui.menu.item.productions")}}@stop

@section("content")


<div class="col-md-12">
    <h1><span class="glyphicon glyphicon-cog"></span> {{trans("ui.menu.item.productions")}}</h1>

    <div class="well well-sm">
        <a class="btn btn-primary" id="add-new"><span class="glyphicon glyphicon-plus"></span> Nuevo</a>
    </div>

    <div class="col-xs-12" style="padding: 0px;">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Filtros</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li {{(!isset($_GET["filter"]))?"class='active'":null}}><a href="{{url('manager/productions')}}">Todos</a></li>
                        <li {{(isset($_GET["filter"]) && $_GET["filter"]==Production::STATE_ACTIVE)?"class='active'":null}}><a href="{{Util::addVariableToUrl(Util::getCurrentUrl(),"filter",  Production::STATE_ACTIVE)}}"><span class="glyphicon glyphicon-ok-sign"></span> Activos</a></li>
                        <li {{(isset($_GET["filter"]) && $_GET["filter"]==Production::STATE_IN_WAIT)?"class='active'":null}}><a href="{{Util::addVariableToUrl(Util::getCurrentUrl(),"filter",  Production::STATE_IN_WAIT)}}"><span class="glyphicon glyphicon-hourglass"></span> En Espera</a></li>
                        <li {{(isset($_GET["filter"]) && $_GET["filter"]==Production::STATE_COMING_SOON)?"class='active'":null}}><a href="{{Util::addVariableToUrl(Util::getCurrentUrl(),"filter",  Production::STATE_COMING_SOON)}}"><span class="glyphicon glyphicon-plane"></span> Proximamente</a></li>
                        <li {{(isset($_GET["filter"]) && $_GET["filter"]==Production::STATE_IN_CINEMA)?"class='active'":null}}><a href="{{Util::addVariableToUrl(Util::getCurrentUrl(),"filter",  Production::STATE_IN_CINEMA)}}"><span class="glyphicon glyphicon-film"></span> Solo en Cines</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <form class="navbar-form navbar-left" role="search" action="" method="GET">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search" placeholder="Buscar por titulos..." value="{{(isset($_GET['search']))?$_GET['search']:null}}">
                                </div>
                                <button type="submit" class="btn btn-default">Buscar</button>
                            </form>
                        </li>

                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
</div>

@include("ui/msg/index",array("message_id"=>2))


<div class="col-xs-12 text-center">
    {{Util::pagination($productions)}}
</div>

<div class="col-lg-12">
    <table class="table table-striped table-hover">
        <tr><th>ID</th><th>{{trans("gen.info.title")}}</th><th>{{trans("gen.info.title.original")}}</th><th>{{trans("gen.info.slug")}}</th><th>{{trans("gen.info.rating")}}</th><th>{{trans("gen.info.duration")}}</th></tr>
        @foreach($productions as $production)
        <tr  data-id="{{$production->id}}" class="production-index">
            <td>{{$production->id}}</td>
            <td>{{$production->title}}</td>
            <td>{{$production->title_original}}</td>
            <td>{{$production->slug}}</td>
            <td>{{(is_null($production->rating_rel))?trans("gen.info.undenfined"):$production->rating_rel}}</td>
            <td>{{(is_null($production->duration))?trans("gen.info.undenfined"):$production->duration." min"}}</td>
        </tr>
        @endforeach
    </table>

    <div class="col-xs-12 text-center">
        {{Util::pagination($productions)}}
    </div>


    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Agregar nueva producción</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enlace de IMDB de la producción</label>
                        <input class="form-control input-lg" id="link" type="text" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    @stop

    @section("script")

    <script>
        var url_site = "{{URL::to('manager/productions/edit')}}/";
    </script>
    @stop