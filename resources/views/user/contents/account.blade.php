<?php

use App\System\Models\User;
use App\System\Library\Enum\Country;

$countries = Country::getAll();
?>
@extends("user/templates/gen",array("title"=>"<span class='glyphicon glyphicon-user'></span> ".trans('ui.menu.item.my.account')))

@section("content")

<div class="page-header">
    <h1>Mis datos</h1>
</div>

<div class="col-lg-12">
    <div class="col-lg-6">
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
            <input type="hidden" name="{{User::ATTR_BIRTH}}" value=""/>
            <select id="day" class="form-control" style='float: left;width:15%;'>
                <option value="none" selected>{{trans("gen.time.day")}}</option>
                @for($i=1;$i<=31;$i++)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>    
            <select id="moth" class="form-control" style='float: left;width:15%;'>
                <option value="none" selected>{{trans("gen.time.month")}}</option>
                @for($i=1;$i<=12;$i++)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select> 
            <select id="year" class="form-control" style='float: left;width:15%;'>
                <option value="none" selected>{{trans("gen.time.year")}}</option>
                @for($i=date('Y')-10;$i>date('Y')-80;$i--)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
            <div style='clear: both;'></div>
        </div>
        <div class="form-group">
            <label>{{trans("gen.info.country")}}</label>
            <select id="country" name='{{User::ATTR_COUNTRY}}' class="form-control">
                <option value="none" selected>{{trans("gen.info.select")}}</option>
                @foreach($countries as $code =>$country)
                <option value='{{$code}}'>{{$country}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>{{trans("gen.info.city")}}</label>
            <input class='form-control' name='{{User::ATTR_CITY}}' value='{{$user->city}}'/>
        </div>
    </div>
</div>

@stop