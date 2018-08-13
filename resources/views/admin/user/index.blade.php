@extends('admin.layouts.iframe')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <form action="" class="form-horizontal">
                <div class="form-group">
                    <div class="col-md-2 control-label">用户名</div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="name">
                    </div>
                </div>
            </form>
        </div>

        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>登陆名</th>
                    <th>姓名</th>
                    <th>角色</th>
                    <th>创建时间</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->username}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->roles->count()?$item->roles->pluck('name')->toString():''}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <a href="{{route('admin.user.edit', $item)}}" class="btn btn-info btn-sm">修改</a>
                            <button type="submit" form="delForm{{$item->id}}" class="btn btn-default btn-sm" title="删除" onclick="return confirm('是否确定？')">删除</button>
                            <form class="form-inline hide" id="delForm{{$item->id}}" action="{{ route('admin.user.destroy', $item) }}" method="post">
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