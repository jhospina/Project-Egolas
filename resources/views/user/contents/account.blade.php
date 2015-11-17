<?php

use App\System\Models\User;
use App\System\Library\Enum\Country;
use \App\System\Models\Util\UserUtil;
use App\System\Library\Complements\DateUtil;

$completation = UserUtil::getPercentageCompleteProfile($user);
$countries = Country::getAll();

$birth = new DateUtil($user->birth . " 0:0:0", "Y-n-j H:i:s");
?>
@extends("user/templates/gen",array("title"=>"<span class='glyphicon glyphicon-user'></span> ".trans('ui.menu.item.my.account'),"path"=>"user/contents/account"))

@section("content")

@include("ui/msg/index",array("message_id"=>1))

<div id="avatar">
    <div id="content-avatar">
        <img class="img-rounded" src="{{(is_null(Auth::user()->avatar))?URL::to("assets/images/user_icon.png"):Auth::user()->avatar}}"/>
    </div>
    <div class="caption">Pulsa en la imagen para cambiar de foto</div>
</div>

<div class="col-lg-12" id="account-content">
    <div class="col-lg-6">
        <div class="page-header">
            <h1>Mis datos</h1>
        </div>
        @if(Auth::user()->role==User::ROLE_SUSCRIPTOR_PREMIUM)
        <div class="col-xs-6" id="time-premium-title"> <img style="width: 25px;vertical-align:top;" src="{{URL::to("assets/images/logo-premium.png")}}"></div>
        <div class="col-xs-6" id="time-premium"><span class="glyphicon glyphicon-time"></span> {{DateUtil::calculateDifference(DateUtil::getCurrentTime(),Auth::user()->premium_to)}}</div>
        @endif
        <div class="clearfix" style="margin-bottom: 20px;"></div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="{{$completation}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$completation}}%;">
                {{$completation}}% Completado
            </div>
        </div>
        <form id="form" action="{{URL::to("user/account/post/save/info")}}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label>{{trans("gen.info.email")}}</label>
                <input class="input-lg form-control" readonly="readonly" disabled="" type="text" value="{{$user->email}}">
            </div>
            <div class="form-group">
                <label>{{trans("gen.info.name")}}</label>
                <input class="input-lg form-control" name="{{User::ATTR_NAME}}" type="text" value="{{$user->name}}">
            </div>
            <div class="form-group">
                <label>{{trans("gen.info.lastname")}}</label>
                <input class="input-lg form-control" name="{{User::ATTR_LASTNAME}}" type="text" value="{{$user->lastname}}">
            </div>
            <div class="form-group">
                <label style='width: 100%'>{{trans("gen.info.birth")}}</label>
                <input type="hidden"  id="{{User::ATTR_BIRTH}}" name="{{User::ATTR_BIRTH}}" value=""/>
                <select id="day" class="form-control" style='float: left;width:15%;'>
                    <option value="none" selected>{{trans("gen.time.day")}}</option>
                    @for($i=1;$i<=31;$i++)
                    <option value="{{$i}}" {{($birth->getDay()==$i)?"selected":null}}>{{$i}}</option>
                    @endfor
                </select>    
                <select id="month" class="form-control" style='float: left;width:15%;'>
                    <option value="none" selected>{{trans("gen.time.month")}}</option>
                    @for($i=1;$i<=12;$i++)
                    <option value="{{$i}}" {{($birth->getMonth()==$i)?"selected":null}}>{{$i}}</option>
                    @endfor
                </select> 
                <select id="year" class="form-control" style='float: left;width:15%;'>
                    <option value="none" selected>{{trans("gen.time.year")}}</option>
                    @for($i=date('Y')-10;$i>date('Y')-80;$i--)
                    <option value="{{$i}}" {{($birth->getYear()==$i)?"selected":null}}>{{$i}}</option>
                    @endfor
                </select>
                <div style='clear: both;'></div>
            </div>
            <div class="form-group">
                <label>{{trans("gen.info.country")}}</label>
                <select id="country" name='{{User::ATTR_COUNTRY}}' class="form-control">
                    <option value="none" selected>{{trans("gen.info.select")}}</option>
                    @foreach($countries as $code =>$country)
                    <option value='{{$code}}' {{($user->country==$code)?"selected":null}}>{{$country}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>{{trans("gen.info.city")}}</label>
                <input class='form-control' type="text" name='{{User::ATTR_CITY}}' value='{{$user->city}}'/>
            </div>
            <div class="form-group text-center">
                <button id="btn-submit" type="button" class="btn btn-primary" ><span class="glyphicon glyphicon-save"></span> {{trans("gen.info.save")}}</button>
            </div>
        </form>
    </div>
    <div class="col-lg-4 col-lg-offset-2" style="    padding: 25px;
         background: #F5F5F5;
         -webkit-border-radius: 5px;
         -moz-border-radius: 5px;
         border-radius: 5px;
         margin-top: 20px;
         border: 1px #D0D0D0 solid;">
        <div class="page-header">
            <h2>Cambiar contraseña</h2>
        </div>
        <form id="form-pass" action="{{URL::to("user/account/post/save/new/pass")}}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Contraseña actual</label>
                <input class='form-control' type="password" id="current-pass" name='current-pass' value=''/>
            </div>
            <div class="form-group">
                <label>Contraseña nueva</label>
                <input class='form-control' type="password" id="new-pass" name='new-pass' value=''/>
            </div>
            <div class="form-group">
                <label>Repetir nueva contraseña</label>
                <input class='form-control' type="password" id="new-pass-rep" name='new-pass-rep' value=''/>
            </div>
            <div class="form-group text-center">
                <button id="btn-submit-pass" type="button" class="btn btn-primary" ><span class="glyphicon glyphicon-lock"></span> Establecer nueva contraseña</button>
            </div>
        </form>
    </div>
</div>
</div>

@stop

@section("script")
<script src='{{URL::to("assets/scripts/library/validations.js")}}'></script>
@stop