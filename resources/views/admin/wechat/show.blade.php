@extends('admin.layouts.iframe')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    @if($info->logo)
                    <img class="profile-user-img img-responsive" src="{{$info->logo}}" alt="logo">
                    @endif

                    <h3 class="profile-username text-center">{{$info->name}}</h3>
                    <p class="text-muted text-center">{{$info->type?'小程序':'公众号'}}</p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>用户</b> <a href="{{route('admin.wechat_users.index', ['wechat'=>$info->id])}}" class="pull-right">{{$info->users_count}}</a>
                        </li>
                        <li class="list-group-item clearfix">
                            <b>测试</b>
                            <p class="pull-right text-danger list-group-item-text">{{route('wechat.index', ['id' => $info->id])}}</p>
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
                    <li>
                        <a href="#oss" data-toggle="tab">阿里云-OSS</a>
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
                                    <div class="form-control-static">{{$info->redirect_url}}</div>
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
                    <div class="tab-pane" id="oss">
                        <form action="{{route('admin.wechat.oss', $info)}}" class="form-horizontal" method="post" autocomplete="off">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label class="control-label col-md-2">access_key</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="access_key" value="{{data_get($info, 'oss.access_key')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">access_secret</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="access_secret" value="{{data_get($info, 'oss.access_secret')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">bucket</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="bucket" value="{{data_get($info, 'oss.bucket')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">endpoint</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="endpoint" value="{{data_get($info, 'oss.endpoint')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">启用 https</label>
                                <div class="col-md-6">
                                    <input type="checkbox" class="switch" name="ssl" value="1" data-size="small" {{data_get($info, 'oss.ssl')?'checked':''}}>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">自定义域名</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="cdnDomain" value="{{data_get($info, 'oss.cdnDomain')}}">
                                    <p class="help-block">不含 http://</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-2">
                                    <button type="submit" class="btn btn-primary">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $.fn.bootstrapSwitch.defaults.onColor = 'success';
            $.fn.bootstrapSwitch.defaults.offColor = 'danger';
            $('input[type="checkbox"].switch').bootstrapSwitch();
        })
    </script>
@endsection
