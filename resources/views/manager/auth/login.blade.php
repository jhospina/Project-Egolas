@include("manager/ui/html/header")

<style>
    body{
        background: #cc0000;
        background: -moz-linear-gradient(top, #cc0000 0%, #cc0000 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#cc0000), color-stop(100%,#cc0000));
        background: -webkit-linear-gradient(top, #cc0000 0%,#cc0000 100%);
        background: -o-linear-gradient(top, #cc0000 0%,#cc0000 100%);
        background: -ms-linear-gradient(top, #cc0000 0%,#cc0000 100%);
        background: linear-gradient(to bottom, #cc0000 0%,#cc0000 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cc0000', endColorstr='#cc0000',GradientType=0 );
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }

    .form-group.last { margin-bottom:0px; }

    #tag-system {
        color: white;
        font-weight: bold;
        font-size: 30pt;
        position: relative;
        left: 300px;
        -webkit-transform: rotate(-20deg);
        transform: rotate(-20deg);
    }
</style>

<div id="page-login">
    <div class="text-center">
        <img src="{{URL::to("assets/images/logo.png")}}">
        <div id="tag-system">System</div>
    </div>

    <div class="container" style="margin-top: 50px;margin-bottom:100px;">
        @include("ui/msg/index",array("message_id"=>1))
        <div class="row">
            <div class="text-center">
                <div class="text-left" style="display: inline-block;width:45%;">
                    <div class="panel panel-default">
                        <div class="panel-heading text-left">
                            <span class="glyphicon glyphicon-lock"></span> {{trans("gen.join.into.system")}}</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">{{trans("user.attr.email")}}</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="inputEmail3" name="{{User::AUTH_EMAIL}}" placeholder="{{trans("user.attr.email")}}" value="{{old('email')}}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-4 control-label">{{trans("user.attr.password")}}</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" name="{{User::AUTH_PASSWORD}}" id="inputPassword3" placeholder="{{trans("user.attr.password")}}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="{{User::AUTH_REMEMBER}}"/>
                                                {{trans("user.attr.rememberme")}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group last">
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <button type="submit" class="btn btn-success btn-sm">{{trans("ui.btn.login")}}</button>
                                        <button type="reset" class="btn btn-default btn-sm">{{trans("ui.btn.clean")}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center" style="color:white;">
        <i>{{trans("gen.copyright")}}</i>
    </div>

</div>

@include("manager/ui/html/footer")