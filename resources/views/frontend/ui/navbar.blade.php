<?php

use App\System\Models\Term;
use App\System\Library\Detection\MobileDetect;

$detect = new MobileDetect();

$categories = Term::orderBy(Term::ATTR_NAME, "ASC")->get();
?>
<nav class="navbar navbar-inverse" id="navbar">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{URL::to("")}}">
            <img class="img-rounded" id="logo" src="{{URL::to("assets/images/logo.png")}}">
        </a>
    </div>
    <div id="nav-info" class="collapse navbar-collapse">
        @if(Auth::check() && !$detect->isMobile() && !$detect->isTablet())
        <ul class="nav navbar-nav" id="explore-menu">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Explorar <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    @foreach($categories as $category)
                    <li><a href="{{URL::to("category/".$category->slug)}}">{{ucfirst($category->mote)}}</a></li>
                    @endforeach
                </ul>
            </li>
        </ul>
        @endif
        <ul class="nav navbar-nav navbar-right" id="bar-user">
            @if(Auth::check())

            @if(!$detect->isMobile() && !$detect->isTablet())
            <li id="search-box" data-url="{{URL::to("")}}" style="@{{(isset($query))?"width:260px;height:34px;":""}}">
                @if(isset($query))
                <div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span><input id="search" style="@{{(isset($query))?"width:200px;":""}}" type="text" class="form-control" value='{{$query}}' placeholder="Títulos, personas..."><span id="loader-search" class="input-group-addon"><span class="glyphicon glyphicon-refresh"></span></div>
                @else
                <a><span class="glyphicon glyphicon-search"></span> {{trans("gen.info.search")}}</a>
                @endif
            </li>      
            <li class="dropdown" style="border-left: 1px #902B2B solid;">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <span style="color:white;">{{Auth::user()->name}}</span>&nbsp;
                    <img class="img-circle" id="img-avatar" src="{{(is_null(Auth::user()->avatar))?URL::to("assets/images/user_icon.png"):Auth::user()->avatar}}"/>            
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{URL::to("user/dashboard")}}"><span class="glyphicon glyphicon-user"></span> Mi cuenta</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{URL::to("user/auth/logout")}}"><span class="glyphicon glyphicon-log-out"></span> {{trans("ui.user.menu.logout")}}</a></li>
                </ul>
            </li>
            @endif

            @endif
        </ul>
    </div>
    {{--MENU MOBILE--}}
    @if(Auth::check() && ($detect->isMobile() || $detect->isTablet()))
    <div id="go-menu-mobile">
        <a>
            <img class="img-circle" id="img-avatar" src="{{(is_null(Auth::user()->avatar))?URL::to("assets/images/user_icon.png"):Auth::user()->avatar}}"/>  
            <span class="glyphicon glyphicon-menu-hamburger"></span>
        </a>
        </li>
    </div>
    <div id="overligth-menu-mob"></div>
    <div id="menu-mobile">
        <div class="search-mobile">
            <div class="form-group">
                <input type="text" class="form-control" id="search-mob" placeholder="Títulos, personas...">
                <button type="button" id="btn-search-mob" class="btn btn-default">Buscar</button>
            </div>
        </div>
        <div class="col-xs-12 h2 text-left" style="color:black;">Explorar</div>
        <div id="categories-mobile">
        <div class="list-group clearfix">
            @foreach($categories as $category)
            <a class="list-group-item" href="{{URL::to("category/".$category->slug)}}"><span class="glyphicon glyphicon-tag"></span> {{ucfirst($category->mote)}}</a>
            @endforeach
        </div>
        </div>
        <div class="list-group my-account">
            <a class="list-group-item" href="{{URL::to("user/dashboard")}}" class="btn btn-danger"><span class="glyphicon glyphicon-user"></span> Mi cuenta</a>
            <a class="list-group-item" href="{{URL::to("user/auth/logout")}}" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Cerrar sesión</a>
        </div>
    </div>
    @endif
</nav>