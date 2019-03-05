@extends('admin.layouts.iframe')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <form action="" class="form-horizontal" autocomplete="off">
                <div class="form-group">
                    <label class="col-md-1 control-label">APP</label>
                    <div class="col-md-2">
                        <select name="wechat_id" class="form-control select2" data-json="{{json_encode($wechat)}}" data-ajax-url="{{route('admin.wechat.search')}}"></select>
                    </div>
                    <label class="col-md-1 control-label">用户</label>
                    <div class="col-md-2">
                        <select name="user_id" class="form-control select2" data-json="{{json_encode($user)}}" data-ajax-url="{{route('admin.wechat_users.search')}}"></select>
                    </div>
                    <label class="col-md-1 control-label">创建时间</label>
                    <div class="col-md-4">
                        <div class="input-group input-daterange">
                            <input type="text" class="form-control date" name="start_time" value="{{request('start_time')}}">
                            <span class="input-group-addon">至</span>
                            <input type="text" class="form-control date" name="end_time" value="{{request('end_time')}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3 pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        <button type="submit" class="btn btn-default" name="export"><i class="glyphicon glyphicon-export"></i> 导出</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="box-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>APP</th>
                    <th>订单号</th>
                    <th>用户</th>
                    <th>金额</th>
                    <th>备注</th>
                    <th>状态</th>
                    <th>下单时间</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $item)
                    <tr>
                        <td><a href="{{route('admin.wechat.show', $item->wechat_id)}}">{{$item->wechat->name}}</a></td>
                        <td>{{$item->out_trade_no}}</td>
                        <td>
                            @if($item->user->nickname)
                                @if($item->user->headimgurl)
                                    <img src="{{$item->user->headimgurl}}" alt="" width="50" class="img-thumbnail">
                                @endif
                                <span>{{$item->user->nickname}}</span>
                                <!-- 用户的性别，值为1时是男性，值为2时是女性，值为0时是未知 -->
                                @if ($item->user->sex == 0)
                                    <i class="fa fa-question text-primary"></i>
                                @elseif ($item->user->sex == 1)
                                    <i class="fa fa-male"></i>
                                @elseif ($item->user->sex == 2)
                                    <i class="fa fa-female text-danger"></i>
                                @endif
                            @else
                                {{$item->user->openid}}
                            @endif
                        </td>
                        <td>{{$item->money}}</td>
                        <td>{{$item->body}}</td>
                        <td>{{$item->status_name}}</td>
                        <th>{{$item->created_at}}</th>
                        <td>
                            <a href="{{route('admin.wechat_order.show', $item->id)}}" class="btn btn-info btn-sm">详细</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="box-footer clearfix">
            {{$list->appends(request()->all())->links()}}
        </div>
    </div>
@endsection
