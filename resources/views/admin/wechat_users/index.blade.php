@extends('admin.layouts.iframe')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <form action="" class="form-horizontal" autocomplete="off">
                <div class="form-group">
                    <div class="col-md-2 control-label">昵称</div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="name" value="{{request('name')}}" placeholder="昵称">
                    </div>
                    <label for="select2" class="col-md-2 control-label">APP</label>
                    <div class="col-md-2">
                        <select name="wechat" class="form-control" id="wechat" data-ajax-url="{{route('admin.wechat.search')}}">
                            <option value=""></option>
                        </select>
                    </div>
                    @if($is_admin)
                        <label for="select2" class="col-md-2 control-label">角色</label>
                        <div class="col-md-2">
                            <select name="role" class="form-control" id="role" data-ajax-url="{{route('api.web.role')}}">
                                <option value=""></option>
                            </select>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <div class="col-md-4 pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="box-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>角色</th>
                    <th>APP</th>
                    <th>openid</th>
                    <th>用户</th>
                    <th>资料</th>
                    <th>创建时间</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->role?$item->role->name:''}}</td>
                        <td><a href="{{route('admin.wechat.show', $item->wechat_id)}}">{{$item->wechat->name}}</a></td>
                        <td>{{$item->openid}}</td>
                        <td>
                            @if($item->headimgurl)
                            <img src="{{$item->headimgurl}}" alt="" width="50" class="img-thumbnail">
                            @endif
                            <span>{{$item->nickname}}</span>
                            <!-- 用户的性别，值为1时是男性，值为2时是女性，值为0时是未知 -->
                            @if ($item->sex == 0)
                                <i class="fa fa-question text-primary"></i>
                            @elseif ($item->sex == 1)
                                <i class="fa fa-male"></i>
                            @elseif ($item->sex == 2)
                                <i class="fa fa-female text-danger"></i>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.wechat_user_msg.index', ['user'=>$item->id])}}">{{$item->messages_count}}</a>
                        </td>
                        <td>{{$item->created_at}}</td>
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
            var item = {!! json_encode($role) !!}
            $('#role').select2({
                allowClear: true,
                placeholder: '请选择',
                data: [item],
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
                    return repo.text?repo.text:repo.name
                },
                templateSelection: function (repo) {
                    return repo.text?repo.text:repo.name
                }
            });
            // 初始化 select2
            if (item) {
                $('#role').val([item.id]).trigger('change');
            }

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
                    return '<div><img src="'+repo.logo+'" alt="" width="20" height="20"> '+repo.name+'</div>';
                },
                templateSelection: function (repo) {
                    if (!repo.logo) {
                        return '';
                    }
                    return '<div><img src="'+repo.logo+'" alt="" width="20" height="20"> '+repo.name+'</div>';
                }
            });
            // 初始化 select2
            if (item_app) {
                $('#wechat').val([item_app.id]).trigger('change');
            }
        })
    </script>
@endsection