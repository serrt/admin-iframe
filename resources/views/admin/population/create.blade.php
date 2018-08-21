@extends('admin.layouts.iframe')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="{{route('admin.population.index')}}" class="btn btn-default"> 返回</a>
    </div>

    <div class="box-body">
        <form action="{{route('admin.population.store')}}" class="form-horizontal validate" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">户主信息</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="avatar" class="control-label col-md-2">头像</label>
                        <div class="col-md-3">
                            <input id="avatar" name="avatar" class="form-control" type="file">
                            <p class="help-block">2M 内的图片</p>
                        </div>
                        <label for="inputNumber" class="control-label col-md-2">户籍编号*</label>
                        <div class="col-md-3">
                            <input type="text" id="inputNumber" class="form-control" name="number" data-rule-required="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selectCommunity" class="control-label col-md-2">社别*</label>
                        <div class="col-md-3">
                            <select name="community" id="selectCommunity" class="form-control select2" data-ajax-url="{{route('api.web.keywords', ['type_key'=>'community'])}}" data-rule-required="true">
                            </select>
                        </div>
                        <label for="selectType" class="control-label col-md-2">户籍类型*</label>
                        <div class="col-md-3">
                            <select name="role" id="selectType" class="form-control select2" data-ajax-url="{{route('api.web.keywords', ['type_key'=>'population_type'])}}" data-rule-required="true">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selectCommunity" class="control-label col-md-2">户主</label>
                        <div class="col-md-3">
                            <select name="role" id="selectCommunity" class="form-control select2-population" data-ajax-url="{{route('admin.population.search')}}">
                                <option></option>
                            </select>
                            <p class="help-block">忽略则为添加户主</p>
                        </div>
                        <label for="inputRelation" class="control-label col-md-2">与户主关系*</label>
                        <div class="col-md-3">
                            <input type="text" id="inputRelation" class="form-control" name="relation" data-rule-required="true">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">基本信息</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputName" class="control-label col-md-2">姓名*</label>
                        <div class="col-md-3">
                            <input type="text" id="inputName" class="form-control" name="name" data-rule-required="true">
                        </div>
                        <label for="inputOldName" class="control-label col-md-2">曾用名</label>
                        <div class="col-md-3">
                            <input type="text" id="inputOldName" class="form-control" name="old_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputIdNumber" class="control-label col-md-2">身份证号码*</label>
                        <div class="col-md-3">
                            <input type="text" id="inputIdNumber" class="form-control" name="id_number" data-rule-required="true">
                        </div>
                        <label class="control-label col-md-2">性别</label>
                        <div class="col-md-3 checkbox">
                            <label><input type="radio" name="sex" value="1" checked> 男</label>
                            <label><input type="radio" name="sex" value="0"> 女</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputBirthday" class="control-label col-md-2">出生日期</label>
                        <div class="col-md-3">
                            <input type="text" id="inputBirthday" class="form-control date" name="birthday">
                        </div>
                        <label for="inputBirthPlace" class="control-label col-md-2">出生地</label>
                        <div class="col-md-3">
                            <input type="text" id="inputBirthPlace" class="form-control" name="birth_place">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPlace" class="control-label col-md-2">籍贯</label>
                        <div class="col-md-3">
                            <input type="text" id="inputPlace" class="form-control" name="place">
                        </div>
                        <label for="selectNation" class="control-label col-md-2">民族</label>
                        <div class="col-md-3">
                            <select name="nation" id="selectNation" class="form-control select2" data-ajax-url="{{route('api.web.keywords', ['type_key'=>'nation'])}}" data-rule-required="true">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selectPolity" class="control-label col-md-2">政治面貌</label>
                        <div class="col-md-3">
                            <select name="polity" id="selectPolity" class="form-control select2" data-ajax-url="{{route('api.web.keywords', ['type_key'=>'polity'])}}" data-rule-required="true">
                            </select>
                        </div>
                        <label for="selectEducation" class="control-label col-md-2">文化程度</label>
                        <div class="col-md-3">
                            <select name="education" id="selectEducation" class="form-control select2" data-ajax-url="{{route('api.web.keywords', ['type_key'=>'education'])}}" data-rule-required="true">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selectMarry" class="control-label col-md-2">婚姻情况</label>
                        <div class="col-md-3">
                            <select name="marry" id="selectMarry" class="form-control select2" data-ajax-url="{{route('api.web.keywords', ['type_key'=>'marry'])}}" data-rule-required="true">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">居住信息</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-2">
                    <button type="submit" class="btn btn-primary">提交</button>
                    <a href="{{route('admin.population.index')}}" class="btn btn-default"> 返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
$(function () {
    $("#avatar").fileinput({
        language: 'zh',
        overwriteInitial: true,
        showClose: false,
        maxFilePreviewSize: 2 * 1024,
        maxFileSize: 2 * 1024,
        showUpload: false,
        uploadAsync: false,
        fileActionSettings: {showRemove: false, showDrag: false},
        initialPreviewAsData: true,
        // initialPreview: '/images/default_avatar_male.jpg',
        browseClass: 'btn bg-purple',
        showCaption: false,
        dropZoneEnabled: false,
        allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif']
    });
    $('#inputIdNumber').on('blur', function () {
        if ($(this).val()) {
            var result = IdCard($(this).val(), 'all');
            if (result.sex) {
                $('input[name="sex"]').val(result.sex);
            }
            if (result.birthday) {
                $('input[name="birthday"]').datepicker('setDate', result.birthday);
            }
        }
    });
})
</script>
@endsection