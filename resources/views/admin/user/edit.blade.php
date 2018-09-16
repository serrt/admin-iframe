@extends('admin.layouts.iframe')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="{{route('admin.user.index')}}" class="btn btn-default"> 返回</a>
    </div>

    <div class="box-body">
        <form action="{{route('admin.user.update',$user)}}" class="form-horizontal validate" method="post">
            {{csrf_field()}}
            {{method_field('put')}}
            <div class="form-group">
                <label for="inputUserName" class="control-label col-md-2">登录名*</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="username" id="inputUserName" value="{{$user->username}}"
                           data-rule-required="true"
                           data-rule-remote="{{route('api.web.unique',['table'=>'admin_users','unique'=>'username','ignore'=>$user->id])}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="control-label col-md-2">密码</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" name="password" id="inputPassword">
                    <p class="help-block">需要强制修改密码, 请填写此项;忽略则不修改密码</p>
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="control-label col-md-2">姓名</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="name" value="{{$user->name}}" id="inputName">
                </div>
            </div>

            <div class="form-group">
                <label for="select2" class="control-label col-md-2">角色</label>
                <div class="col-md-8 btn-group">
                    <select name="roles[]" class="form-control" id="select2" data-ajax-url="{{route('api.web.role')}}" multiple>
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-2">
                    <button type="submit" class="btn btn-primary">提交</button>
                    <a href="{{route('admin.user.index')}}" class="btn btn-default"> 返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(function () {
            var items = JSON.parse('{!! json_encode($user_roles) !!}');
            $('#select2').select2({
                allowClear: true,
                placeholder: '请选择',
                data: items,
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
            if (items) {
                var selected_ids = [];
                for (var i in items) {
                    selected_ids.push(items[i].id);
                }
                $('#select2').val(selected_ids).trigger('change');
            }
        })
    </script>
@endsection