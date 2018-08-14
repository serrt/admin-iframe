@extends('admin.layouts.iframe')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="{{route('admin.keywords.index')}}" class="btn btn-default"> 返回</a>
    </div>

    <div class="box-body">
        <form action="{{route('admin.keywords.store')}}" class="form-horizontal validate" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputType" class="control-label col-md-2">类型*</label>
                <div class="col-md-8">
                    <select name="type" id="inputType" class="form-control" data-rule-required="true" data-ajax-url="{{route('api.web.keywords_type')}}">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputKey" class="control-label col-md-2">key*</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="key" id="inputKey" data-rule-required="true" data-rule-remote="{{route('admin.keywords.check')}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="control-label col-md-2">名称*</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="name" id="inputName" data-rule-required="true">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-2">
                    <button type="submit" class="btn btn-primary">提交</button>
                    <a href="{{route('admin.keywords.index')}}" class="btn btn-default"> 返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
    <script>
        var item = {!! json_encode($type) !!}
        $('#inputType').select2({
            language: "zh-CN",
            placeholder: '请选择',
            data: [item],
            allowClear: true,
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
                return repo.key?repo.key+'--'+repo.name:''
            },
            templateSelection: function (repo) {
                return repo.key?repo.key+'--'+repo.name:''
            }
        });
        if (item) {
            $('#inputType').val([item.id]).trigger('change');
        }
    </script>
@endsection