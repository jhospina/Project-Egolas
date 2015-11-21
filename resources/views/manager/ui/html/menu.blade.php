<div class="list-group" id="menu-list">
    <a class="list-group-item menu-item" href="{{URL::to("manager/dashboard")}}"><span class="glyphicon glyphicon-dashboard"></span> {{trans("ui.menu.item.dashboard")}}</a>
    <a class="list-group-item menu-item" href="{{URL::to("manager/productions")}}"><span class="glyphicon glyphicon-facetime-video"></span> {{trans("ui.menu.item.productions")}}</a>
    <a class="list-group-item menu-item"><span class="glyphicon glyphicon-globe"></span> {{trans("ui.menu.item.autogenerator")}}</a>
    <a class="list-group-item submenu-item" href="{{URL::to("manager/auto/process")}}"><span class="glyphicon glyphicon-cog"></span> {{trans("ui.menu.item.autogenerator.processes")}}</a>
    <a class="list-group-item submenu-item" href="{{URL::to("manager/auto/live/productions")}}"><span class="glyphicon glyphicon-play-circle"></span> {{trans("ui.menu.item.autogenerator.live.productions")}}</a>   
    <a class="list-group-item menu-item" href="{{URL::to("manager/reports")}}"><span class="glyphicon glyphicon-alert"></span> Reporte de problemas</a>
    <a class="list-group-item menu-item" href="{{URL::to("manager/productions/videomega/")}}"><span class="glyphicon glyphicon-wrench"></span> Generador Videomega.tv</a>
</div>