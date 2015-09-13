@include("manager/ui/html/header")

<nav class="navbar navbar-inverse" id="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{URL::to("manager/dashboard")}}">
                <img class="img-rounded" style="width: 150px;" id="logo-okonexion" src="{{URL::to("assets/images/logo.png")}}">
            </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        @if(Auth::check())
                        {{ Auth::user()->name }}
                        @endif
                        <span class="glyphicon glyphicon-user"></span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::to("manager/password/edit")}}"><span class="glyphicon glyphicon-lock"></span> {{trans("ui.user.menu.edit.password")}}</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{URL::to("manager/auth/logout")}}"><span class="glyphicon glyphicon-log-out"></span> {{trans("ui.user.menu.logout")}}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="main">
    <div id="menu" class="col-md-2">
        @include("manager/ui/html/menu")
    </div>
    <div style="height:100%;" class="col-md-2">

    </div>
    <div id="content" class=" col-md-10">
        @yield("content")
    </div>
</div>


@include("manager/ui/html/footer")