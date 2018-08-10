@extends('admin.layouts.iframe')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3>基本表单</h3>
            </div>
            <div class="box-body">
                <form action="" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Input</label>
                        <div class="col-lg-10">
                            <input type="text" name="" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Select</label>
                        <div class="col-lg-10">
                            <select name="" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Select2</label>
                        <div class="col-lg-10">
                            <select name="" class="form-control select2">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Date</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">Date Time</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control datetime">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3>文件上传</h3>
            </div>
            <div class="box-body">
                <form action="{{route('admin.index.form_upload')}}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">File1</label>
                        <div class="col-lg-10">
                            <input type="file" name="file" class="form-control file-input1">
                            <p class="help-block">单文件表单上传</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">File1</label>
                        <div class="col-lg-10">
                            <input type="file" name="files[]" class="form-control file-input2" multiple>
                            <p class="help-block">多文件表单上传</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3>多文件管理</h3>
            </div>
            <div class="box-body">
                <form action="" class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <input type="file" name="files2" class="form-control file-input3" data-upload-url="{{route('api.web.upload')}}" multiple>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(function () {
        $('.file-input1').fileinput({
            language: 'zh',
            showUpload: false,
            dropZoneEnabled: false,
            uploadAsync: false,
        });
        $('.file-input2').fileinput({
            language: 'zh',
            showUpload: false,
            uploadAsync: false,
        });

        var url1 = 'http://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/FullMoon2010.jpg/631px-FullMoon2010.jpg',
            url2 = 'http://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Earth_Eastern_Hemisphere.jpg/600px-Earth_Eastern_Hemisphere.jpg';
        $('.file-input3').fileinput({
            language: 'zh',
            showUpload: false,
            overwriteInitial: false,
            initialPreview: [url1, url2],
            initialPreviewAsData: true,
            showAjaxErrorDetails: false,
        });
    })
</script>
@endsection