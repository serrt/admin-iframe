@extends('admin.layouts.iframe')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <form action="" class="form-horizontal" autocomplete="off">
                <div class="form-group">
                    <div class="col-md-2 control-label">名称</div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="name" value="{{request('name')}}" placeholder="名称">
                    </div>
                    <div class="col-md-2 control-label">类型</div>
                    <div class="col-md-2">
                        <select class="form-control" name="type" data-type="{{$type}}">
                            <option value="all" {{$type=='all'?'selected':''}}>全部</option>
                            <option value="0" {{!$type?'selected':''}}>公众号</option>
                            <option value="1" {{$type==1?'selected':''}}>小程序</option>
                        </select>
                    </div>
                    @if($is_admin)
                    <label for="select2" class="col-md-2 control-label">角色</label>
                    <div class="col-md-2">
                        <select name="role" class="form-control" id="select2" data-ajax-url="{{route('api.web.role')}}">
                            <option value=""></option>
                        </select>
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <div class="col-md-4 pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        <a href="{{route('admin.wechat.create')}}" class="btn btn-default"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>角色</th>
                    <th>类型</th>
                    <th>名称</th>
                    <th>用户</th>
                    <th>创建时间</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->role?$item->role->name:''}}</td>
                        <td>{{$item->type?'小程序':'公众号'}}</td>
                        <td>
                            <img src="{{$item->logo}}" alt="" width="50" class="img-thumbnail">
                            <a href="{{route('admin.wechat.show', $item)}}">{{$item->name}}</a>
                        </td>
                        <td><a href="{{route('admin.wechat_users.index', ['wechat'=>$item->id])}}">{{$item->users_count}}</a></td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <a href="{{route('admin.wechat.show', $item)}}" class="btn btn-info btn-sm">查看</a>
                            <a href="{{route('admin.wechat.edit', $item)}}" class="btn btn-primary btn-sm">修改</a>
                            <button type="submit" form="delForm{{$item->id}}" class="btn btn-default btn-sm" title="删除" onclick="return confirm('是否确定？')">删除</button>
                            <form class="form-inline hide" id="delForm{{$item->id}}" action="{{ route('admin.wechat.destroy', $item) }}" method="post">
                                {{ csrf_field() }} {{ method_field('DELETE') }}
                            </form>
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
            var item = {!! json_encode($role) !!}
            $('#select2').select2({
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
                $('#select2').val([item.id]).trigger('change');
            }
        })
    </script>
@endsection