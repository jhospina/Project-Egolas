<nav class="navbar navbar-inverse" id="navbar">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{URL::to("")}}">
            <img class="img-rounded" style="width: 250px;height:58px;" id="logo" src="{{URL::to("assets/images/logo.png")}}">
        </a>
    </div>
    <div id="nav-info" class="collapse navbar-collapse">
        <div class="nav navbar-nav navbar-right">
            @if(isset($title))
            <div id="title-section" class="h1">{{$title}}</div>
            @endif
        </div>
    </div>
</nav>