@extends('admin.layouts.iframe')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <form action="" class="form-horizontal" autocomplete="off">
                <div class="form-group">
                    <div class="col-md-2 control-label">用户名</div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="name" value="{{request('name')}}" placeholder="登录名/姓名">
                    </div>
                    <label for="select2" class="col-md-2 control-label">角色</label>
                    <div class="col-md-2">
                        <select name="role" class="form-control select2">
                            <option value="">全部</option>
                            @foreach($roles as $role)
                                <option value="{{$role->id}}" {{request('role') == $role->id?'selected':''}}>{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        <a href="{{route('admin.user.create')}}" class="btn btn-default"><i class="fa fa-plus"></i> 添加</a>
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
                        <td>
                            @if($item->isAdmin())
                            {{$item->username}}
                            @else
                            <a href="{{route('admin.user.edit', $item)}}" class="btn-link">{{$item->username}}</a>
                            @endif
                        </td>
                        <td>{{$item->name}}</td>
                        @if($item->isAdmin())
                        <td class="text-danger">超级管理员拥有全部权限</td>
                        @else
                        <td>
                            {{$item->roles->count()?$item->roles->implode('name', ','):''}}
                        </td>
                        @endif
                        <td>{{$item->created_at}}</td>
                        <td>
                            @if(!$item->isAdmin())
                            <a href="{{route('admin.user.edit', $item)}}" class="btn btn-info btn-sm">修改</a>
                            <button type="submit" form="delForm{{$item->id}}" class="btn btn-default btn-sm" title="删除" onclick="return confirm('是否确定？')">删除</button>
                            <form class="form-inline hide" id="delForm{{$item->id}}" action="{{ route('admin.user.destroy', $item) }}" method="post">
                                {{ csrf_field() }} {{ method_field('DELETE') }}
                            </form>
                            @endif
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
