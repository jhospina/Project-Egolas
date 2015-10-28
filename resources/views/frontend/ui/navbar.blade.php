<nav class="navbar navbar-inverse" id="navbar">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{URL::to("")}}">
            <img class="img-rounded" style="width: 250px;height:58px;" id="logo" src="{{URL::to("assets/images/logo.png")}}">
        </a>
    </div>
    <div id="nav-info" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right" id="bar-user">
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
                    @if(Auth::check())
                    <img class="img-circle" id="img-avatar" src="{{(is_null(Auth::user()->avatar))?URL::to("assets/images/user_icon.png"):Auth::user()->avatar}}"/>
                    @endif
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{URL::to("user/dashboard")}}"><span class="glyphicon glyphicon-user"></span> Mi cuenta</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{URL::to("user/auth/logout")}}"><span class="glyphicon glyphicon-log-out"></span> {{trans("ui.user.menu.logout")}}</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>