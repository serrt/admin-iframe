@extends('admin.layouts.iframe')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <form action="" class="form-horizontal" autocomplete="off">
                <div class="form-group">
                    <div class="col-md-2 control-label">名称</div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="name" value="{{request('name')}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        <a href="{{route('admin.role.create')}}" class="btn btn-default"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="box-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>名称</th>
                    <th>APP</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td><a href="{{route('admin.wechat.index', ['role' => $item->id])}}">{{$item->wechats_count}}</a></td>
                        <td>
                            <a href="{{route('admin.role.edit', $item)}}" class="btn btn-info btn-sm">分配权限</a>
                            <button type="submit" form="delForm{{$item->id}}" class="btn btn-default btn-sm" title="删除" onclick="return confirm('是否确定？')">删除</button>
                            <form class="form-inline hide" id="delForm{{$item->id}}" action="{{ route('admin.role.destroy', $item) }}" method="post">
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