<nav class="navbar navbar-inverse" id="navbar">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{URL::to("")}}">
            <img class="img-rounded" style="width: 250px;height:58px;" id="logo" src="{{URL::to("assets/images/logo.png")}}">
        </a>
    </div>
    <div id="nav-info" class="collapse navbar-collapse">
        <div class="nav navbar-nav navbar-right" id="bar-user">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
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
        </div>
    </div>
</nav>