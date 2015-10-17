<?php

use App\System\Library\Complements\Util;
use App\System\Library\Media\Image;
use Illuminate\Support\Facades\Storage;

$url = Util::getCurrentUrl();

?>
<div id="menu" class="col-md-2">

    <div id="avatar">
        <div id="content-avatar">
            <img class="img-rounded" src="{{(is_null(Auth::user()->avatar))?URL::to("assets/images/user_icon.png"):Auth::user()->avatar}}"/>
            
            <div id="action-edit-avatar">
                <div id="icon-edit-avatar">
                <span class="glyphicon glyphicon-camera"></span>
                <label>Actualizar foto de perfil</label>
                </div>
            </div>
        </div>     
    </div>

    <div class="list-group">
        <a href="{{URL::to("user/dashboard")}}" class="list-group-item {{(strpos($url,"dashboard")!==false)?'active':null}}"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a>
        <a href="{{URL::to("user/account")}}" class="list-group-item {{(strpos($url,"account")!==false)?'active':null}}"><span class="glyphicon glyphicon-user"></span> {{trans('ui.menu.item.my.account')}}</a>
        <a href="{{URL::to("user/auth/logout")}}" class="list-group-item"><span class="glyphicon glyphicon-log-out"></span> {{trans("ui.user.menu.logout")}} </a>
    </div>

</div>



       
        
<div class="modal fade"  id="modal-avatar" tabindex="-1" role="dialog" aria-labelledby="modal-avatar" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="color:black;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 class="modal-title">Actualizar foto de perfil</h1>
            </div>
            <div class="modal-body text-justify">
                <div id="msg-error-upload-avatar" style="display: none;" class="alert alert-danger"></div>
                  <input id="upload-avatar" name="upload-avatar" accept="image/*" type="file" multiple=true>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->