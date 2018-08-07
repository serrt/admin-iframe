@extends('admin.layouts.iframe')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <form action="" class="form-horizontal" autocomplete="off" id="searchForm">
            <div class="form-group">
                <label for="" class="col-md-2 control-label">上级</label>
                <div class="col-md-2">
                    <select name="pid" title="上级" class="form-control select2" data-ajax-url="{{route('api.city.index')}}">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-md-2">
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

@section('script')
<script>
    $('.select2').select2({
        language: "zh-CN",
        allowClear: true,
        placeholder: '请选择',
        dataType: 'json',
        width: '100%',
        ajax: {
            delay: 250,
            data: function (params) {
                return {
                    name: params.term,
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
        minimumInputLength: 1,
        escapeMarkup: function (markup) { return markup; },
        templateResult: function (repo) {
            var unit = {1: '省级', 2: '市级', 3: '区级'};
            return repo.name?repo.name+'--'+unit[repo.level]:'搜索中...'
        },
        templateSelection: function (repo) {
            var unit = {1: '省级', 2: '市级', 3: '区级'};
            return repo.name?repo.name+'--'+unit[repo.level]:''
        }
    });
    $('.select2').on('select2:select', function (e) {
        $('#searchForm').submit();
    });
</script>
@endsection
