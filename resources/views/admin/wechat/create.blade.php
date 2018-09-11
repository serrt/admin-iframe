@extends('admin.layouts.iframe')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <a href="javascript:history.back()" class="btn btn-default"> 返回</a>
        </div>

        <div class="box-body">
            <form action="{{route('admin.wechat.store')}}" class="form-horizontal validate" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="selectRole" class="col-md-2 control-label">角色*</label>
                    <div class="col-md-8">
                        <select name="role_id" id="selectRole" class="form-control select2" data-ajax-url="{{route('api.web.role', ['user_id' => $user->isAdmin()?'':$user->id])}}" data-rule-required="true">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputLogo" class="col-md-2 control-label">logo</label>
                    <div class="col-md-8">
                        <input type="file" id="inputLogo" name="logo" class="file-input">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 control-label">类型</div>
                    <div class="col-md-8 checkbox">
                        <label><input type="radio" name="type" value="{{\App\Models\Wechat::TYPE_MP}}" checked> 公众号</label>
                        <label><input type="radio" name="type" value="{{\App\Models\Wechat::TYPE_MIN}}"> 小程序</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputName" class="col-md-2 control-label">名称*</label>
                    <div class="col-md-8">
                        <input type="text" id="inputName" class="form-control" name="name" value="{{old('name')}}" data-rule-required="true">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAppId" class="col-md-2 control-label">app_id*</label>
                    <div class="col-md-8">
                        <input type="text" id="inputAppId" class="form-control" name="app_id" value="{{old('app_id')}}" data-rule-required="true">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAppSecret" class="col-md-2 control-label">secret*</label>
                    <div class="col-md-8">
                        <input type="text" id="inputAppSecret" class="form-control" name="app_secret" value="{{old('app_secret')}}" data-rule-required="true">
                    </div>
                </div>
                <div id="collapseExample">
                    <div class="form-group">
                        <label for="inputSuccessUrl" class="col-md-2 control-label">success_url</label>
                        <div class="col-md-8">
                            <input type="url" id="inputSuccessUrl" class="form-control" name="success_url" value="{{old('success_url')}}">
                            <p class="help-block">授权成功后跳转的地址</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2 control-label">网页授权</div>
                        <div class="col-md-8 checkbox">
                            <label><input type="radio" name="scope" value="{{\App\Models\Wechat::SCOPE_USERINFO}}" checked> 非静默授权</label>
                            <label><input type="radio" name="scope" value="{{\App\Models\Wechat::SCOPE_BASE}}"> 静默授权</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-2">
                        <button type="submit" class="btn btn-primary">提交</button>
                        <a href="{{route('admin.wechat.index')}}" class="btn btn-default"> 返回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $('.file-input').fileinput({
                language: 'zh',
                dropZoneEnabled: false,
                uploadAsync: false,
                showUpload: false,
                showCaption: false,
                fileActionSettings: {
                    showRemove: false,
                    showDrag: false
                },
                browseClass: 'btn bg-purple',
                initialPreviewDelimiter: ',',
                initialPreviewAsData: true,
                showClose: false,
                showRemove: false,
                allowedFileTypes: ['image'],
                removeFromPreviewOnError: true,
                maxFileSize: 500
            });
            $('#collapseExample').collapse({
                toggle: true
            });
            $('[name="type"]').change(function () {
                $('#collapseExample').collapse('toggle');
            });
        })
    </script>
@endsection
