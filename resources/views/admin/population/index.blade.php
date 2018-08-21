@extends('admin.layouts.iframe')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <form action="" class="form-horizontal box no-border collapsed-box" autocomplete="off">
                <div class="form-group">
                    <div class="col-md-12">
                        <a href="{{route('admin.population.create')}}" class="btn btn-instagram"><i class="fa fa-plus-circle"></i> 出生</a>
                        <button type="button" class="btn btn-instagram"><i class="fa fa-plus-square"></i> 迁入</button>
                        <button type="button" class="btn btn-instagram"><i class="fa fa-users"></i> 分户</button>
                        <button type="button" class="btn btn-instagram"><i class="fa fa-user-circle-o"></i> 合户</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">姓名</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="name" name="name" value="{{request('name')}}">
                    </div>
                    <label for="selectCommunity" class="col-md-2 control-label">社别</label>
                    <div class="col-md-2">
                        <select name="role" id="selectCommunity" class="form-control select2" data-ajax-url="{{route('api.web.keywords', ['type_key'=>'community'])}}">
                            <option value="">全部</option>
                        </select>
                    </div>

                    <div class="box-tools pull-right col-md-2">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i> 更多查询条件</button>
                    </div>
                </div>
                <!-- 更多的查询条件 可折叠 -->
                <div class="box-body no-padding" style="display: none">
                    <div class="form-group">
                        <label for="master" class="col-md-2 control-label">户主</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="master" name="master" value="{{request('master')}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>户籍编号</th>
                    <th>户主</th>
                    <th>姓名</th>
                    <th>关系</th>
                    <th>身份证</th>
                    <th>居住地址</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $item)
                    <tr>
                        <td>{{$item->number}}</td>
                        <td>{{$item->master}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->relation}}</td>
                        <td>{{$item->id_number}}</td>
                        <td>{{$item->address}}</td>
                        <td>
                            {{--<a href="{{route('admin.user.edit', $item)}}" class="btn btn-info btn-sm">修改</a>
                            <button type="submit" form="delForm{{$item->id}}" class="btn btn-default btn-sm" title="删除" onclick="return confirm('是否确定？')">删除</button>
                            <form class="form-inline hide" id="delForm{{$item->id}}" action="{{ route('admin.user.destroy', $item) }}" method="post">
                                {{ csrf_field() }} {{ method_field('DELETE') }}
                            </form>--}}
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