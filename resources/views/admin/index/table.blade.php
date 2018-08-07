@extends('admin.layouts.iframe')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <form action="" class="form-horizontal" autocomplete="off">
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">上级</label>
                <div class="col-sm-3">
                    <select name="pid" title="上级" class="form-control select2" data-ajax-url="{{route('api.city.index')}}">
                        <option value=""></option>
                    </select>
                </div>
                <label for="" class="col-sm-2 control-label">名称</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" title="名称" name="name" value="{{request('name')}}">
                </div>

                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                </div>
            </div>
        </form>
    </div>

    <div class="box-body">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>上级</th>
                <th>名称</th>
                <th>code</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->parent?$item->parent->name:'--'}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->code}}</td>
                <td></td>
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
