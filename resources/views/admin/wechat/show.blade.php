@extends('admin.layouts.iframe')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive" src="{{$info->logo}}" alt="logo">

                    <h3 class="profile-username text-center">{{$info->name}}</h3>
                    <p class="text-muted text-center">{{$info->type?'小程序':'公众号'}}</p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>用户</b> <a href="{{route('admin.wechat_users.index')}}" class="pull-right">{{$info->users_count}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>测试</b>
                            <a href="{{route('wechat.index', ['id' => $info->id])}}" class="">{{route('wechat.index', ['id' => $info->id])}}</a>
                            <img class="text-right" src="data:image/png;base64, {{ base64_encode(\QrCode::format('png')->size(100)->generate(route('wechat.index', ['id' => $info->id]))) }}" alt="">
                        </li>
                    </ul>

                    <a href="javascript:history.back()" class="btn btn-default btn-block">返回</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#info" data-toggle="tab">基本信息</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="info">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-2 control-label">角色</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{$info->role?$info->role->name:''}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 control-label">APP_Id</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{$info->app_id}}</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 control-label">APP_SECRET</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{$info->app_secret}}</div>
                                </div>
                            </div>
                            @if (!$info->type)
                            <div class="form-group">
                                <div class="col-sm-2 control-label">授权地址</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{preg_replace('/(http:\/\/)|(https:\/\/)/i', '', config('app.url'))}}</div>
                                    <p class="text-danger">请在公众号中 <code>网页授权获取用户基本信息</code> 配置此地址</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 control-label">回跳地址</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{$info->success_url}}</div>
                                    <p class="text-danger">授权成功后,默认回跳地址,并带上唯一token</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 control-label">授权方式</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{$info->scope?'非静默授权':'静默授权'}}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
