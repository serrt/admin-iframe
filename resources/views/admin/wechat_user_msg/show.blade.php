@extends('admin.layouts.iframe')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{$info->user->headimgurl}}" alt="logo">

                    <h3 class="profile-username text-center">
                        {{$info->user->nickname}}
                        <!-- 用户的性别，值为1时是男性，值为2时是女性，值为0时是未知 -->
                        @if ($info->user->sex == 0)
                            <i class="fa fa-question text-primary"></i>
                        @elseif ($info->user->sex == 1)
                            <i class="fa fa-male"></i>
                        @elseif ($info->user->sex == 2)
                            <i class="fa fa-female text-danger"></i>
                        @endif
                    </h3>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>APP</b>
                            <a href="{{route('admin.wechat.show', $info->wechat)}}" class="pull-right">
                                <img src="{{$info->wechat->logo}}" alt="" width="40">
                                {{$info->wechat->name}}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>注册时间</b>
                            <a href="javascript:void(0)" class="pull-right">{{$info->user->created_at}}</a>
                        </li>

                        <li class="list-group-item">
                            <b>留资时间</b>
                            <a href="javascript:void(0)" class="pull-right">{{$info->created_at}}</a>
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
                        <a href="#info" data-toggle="tab">资料</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="info">
                        <div class="form-horizontal">
                            @if($info->wx_id)
                            <div class="form-group">
                                <div class="col-sm-2 control-label">微信号</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{$info->wx_id}}</div>
                                </div>
                            </div>
                            @endif
                            @if($info->name)
                            <div class="form-group">
                                <div class="col-sm-2 control-label">姓名</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{$info->name}}</div>
                                </div>
                            </div>
                            @endif
                            @if($info->phone)
                            <div class="form-group">
                                <div class="col-sm-2 control-label">电话</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{$info->phone}}</div>
                                </div>
                            </div>
                            @endif
                            @if ($info->province || $info->city || $info->area)
                            <div class="form-group">
                                <div class="col-sm-2 control-label">地区</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{$info->province.'-'.$info->city.'-'.$info->area}}</div>
                                </div>
                            </div>
                            @endif
                            @if($info->address)
                            <div class="form-group">
                                <div class="col-sm-2 control-label">地址</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{$info->address}}</div>
                                </div>
                            </div>
                            @endif
                            @if($info->data)
                            @if(is_array(json_decode($info->data)))
                            @foreach(json_decode($info->data) as $key => $value)
                            <div class="form-group">
                                <div class="col-sm-2 control-label">{{$key}}</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{$value}}</div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="form-group">
                                <div class="col-sm-2 control-label">data</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{$info->data}}</div>
                                </div>
                            </div>
                            @endif
                            @endif
                            @if($info->file)
                                <div class="form-group">
                                    <div class="col-sm-2 control-label">附件</div>
                                    <div class="col-md-10">
                                        <div class="form-control-static">{{$info->file}}</div>
                                    </div>
                                </div>
                            @endif
                            @if($info->remarks)
                            <div class="form-group">
                                <div class="col-sm-2 control-label">备注</div>
                                <div class="col-md-10">
                                    <div class="form-control-static">{{$info->remarks}}</div>
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
