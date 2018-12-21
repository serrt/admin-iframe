@extends('admin.layouts.iframe')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <form action="" class="form-horizontal" autocomplete="off">
                <div class="form-group">
                    <label class="col-md-2 control-label">用户</div>
                    <div class="col-md-2">
                        <select name="user" class="form-control" id="user" data-ajax-url="{{route('admin.wechat_users.search')}}">
                            <option value=""></option>
                        </select>
                    </div>
                    <label class="col-md-2 control-label">APP</label>
                    <div class="col-md-2">
                        <select name="wechat" class="form-control" id="wechat" data-ajax-url="{{route('admin.wechat.search')}}">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">创建时间</label>
                    <div class="col-md-2">
                        <input type="text" name="start_time" class="form-control datetime" value="{{request('start_time')}}">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="end_time" class="form-control datetime" value="{{request('end_time')}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 pull-right">
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
                    <th>#</th>
                    <th>APP</th>
                    <th>用户</th>
                    <th>姓名</th>
                    <th>电话</th>
                    <th>创建时间</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td><a href="{{route('admin.wechat.show', $item->wechat_id)}}">{{$item->wechat->name}}</a></td>
                        <td>
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
                        </td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->phone}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <a href="{{route('admin.wechat_user_msg.show', $item)}}" class="btn btn-info btn-sm">详细</a>
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
@section('script')
    <script>
        $(function () {
            var item_app = {!! json_encode($wechat) !!}
            $('#wechat').select2({
                allowClear: true,
                placeholder: '请选择',
                data: [item_app],
                dataType: 'json',
                width: '100%',
                ajax: {
                    delay: 500,
                    data: function (params) {
                        return {
                            key: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.data,
                            pagination: {
                                more: data.meta?data.meta.current_page < data.meta.last_page:false
                            }
                        };
                    },
                },
                escapeMarkup: function (markup) { return markup; },
                templateResult: function (repo) {
                    if (repo.loading) {
                        return repo.text;
                    }
                    var html = '<div>';
                    if (repo.logo) {
                        html += '<img src="'+repo.logo+'" alt="" width="20" height="20">';
                    }
                    html += repo.name+'</div>';
                    return html;
                },
                templateSelection: function (repo) {
                    if (!repo.name) {
                        return '';
                    }
                    var html = '<div>';
                    if (repo.logo) {
                        html += '<img src="'+repo.logo+'" alt="" width="20" height="20">';
                    }
                    html += repo.name+'</div>';
                    return html;
                }
            });
            // 初始化 select2
            if (item_app) {
                $('#wechat').val([item_app.id]).trigger('change');
            }

            var item_user = {!! json_encode($user) !!}
            $('#user').select2({
                allowClear: true,
                placeholder: '请选择',
                data: [item_user],
                dataType: 'json',
                width: '100%',
                ajax: {
                    delay: 500,
                    data: function (params) {
                        return {
                            name: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.data,
                            pagination: {
                                more: data.meta?data.meta.current_page < data.meta.last_page:false
                            }
                        };
                    },
                },
                escapeMarkup: function (markup) { return markup; },
                templateResult: function (repo) {
                    if (repo.loading) {
                        return repo.text;
                    }
                    return '<div><img src="'+repo.headimgurl+'" alt="" width="20" height="20"> '+repo.nickname+'</div>';
                },
                templateSelection: function (repo) {
                    if (!repo.headimgurl) {
                        return '';
                    }
                    return '<div><img src="'+repo.headimgurl+'" alt="" width="20" height="20"> '+repo.nickname+'</div>';
                }
            });
            // 初始化 select2
            if (item_user) {
                $('#user').val([item_user.id]).trigger('change');
            }
        })
    </script>
@endsection
