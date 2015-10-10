<?php

use App\System\Library\Complements\Util;

$url = Util::getCurrentUrl();
?>
<div id="menu" class="col-md-2">

    <div id="avatar">
        <img class="img-rounded" src="{{URL::to("assets/images/user_icon.png")}}"/>
    </div>

    <div class="list-group">
        <a href="{{URL::to("user/dashboard")}}" class="list-group-item {{(strpos($url,"dashboard")!==false)?'active':null}}"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a>
        <a href="{{URL::to("user/account")}}" class="list-group-item {{(strpos($url,"account")!==false)?'active':null}}"><span class="glyphicon glyphicon-user"></span> {{trans('ui.menu.item.my.account')}}</a>
        <a href="{{URL::to("user/auth/logout")}}" class="list-group-item"><span class="glyphicon glyphicon-log-out"></span> {{trans("ui.user.menu.logout")}} </a>
    </div>

</div>