@extends('admin.layouts.iframe')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3 class="profile-username text-center">{{$info->out_trade_no}}</h3>
                    <p class="text-muted text-center">{{$info->status_name}}</p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>用户</b>
                            <p class="pull-right list-group-item-text">{{$wechat->name}}({{$wechat->type_name}})</p>
                        </li>
                        <li class="list-group-item">
                            <b>用户</b>
                            <p class="text-right list-group-item-text">
                                @if($user->nickname)
                                    <img src="{{$user->headimgurl}}" alt="" width="50" class="img-thumbnail">
                                    {{$user->nickname}}
                                @else
                                    {{$user->openid}}
                                @endif
                            </p>
                        </li>
                        <li class="list-group-item">
                            <b>订单金额</b>
                            <p class="pull-right list-group-item-text text-danger">{{$info->money}}</p>
                        </li>
                        <li class="list-group-item">
                            <b>订单备注</b>
                            <p class="pull-right list-group-item-text">{{$info->body}}</p>
                        </li>
                        <li class="list-group-item">
                            <b>支付方式</b>
                            <p class="pull-right list-group-item-text">{{$info->type_name}}</p>
                        </li>
                        <li class="list-group-item">
                            <b>创建时间</b>
                            <p class="pull-right list-group-item-text">{{$info->created_at}}</p>
                        </li>
                        @if($info->success_time)
                        <li class="list-group-item">
                            <b>支付时间</b>
                            <p class="pull-right list-group-item-text text-success">{{$info->success_time}}</p>
                        </li>
                        @endif

                        @if($info->cancel_time)
                            <li class="list-group-item">
                                <b>支付时间</b>
                                <p class="pull-right list-group-item-text">{{$info->cancel_time}}</p>
                            </li>
                        @endif
                    </ul>

                    <a href="javascript:history.back()" class="btn btn-default btn-block">返回</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#info" data-toggle="tab">退款记录</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="info">
                        <div class="form-horizontal">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
