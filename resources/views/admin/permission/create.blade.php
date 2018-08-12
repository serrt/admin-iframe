@extends('admin.layouts.iframe')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="{{route('admin.permission.index')}}" class="btn btn-default"> 返回</a>
    </div>

    <div class="box-body">
        <form action="{{route('admin.permission.store')}}" class="form-horizontal validate" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputName" class="control-label col-md-2">名称*</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="name" id="inputName" data-rule-required="true">
                </div>
            </div>
            <div class="form-group">
                <label for="selectPid" class="control-label col-md-2">上级</label>
                <div class="col-md-8">
                    <select name="pid" class="form-control select2" id="selectPid">
                        <option value="0">无</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUrl" class="control-label col-md-2">链接</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="url" id="inputUrl">
                </div>
            </div>
            <div class="form-group">
                <label for="inputKey" class="control-label col-md-2">key</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="key" id="inputKey">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-2">
                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
