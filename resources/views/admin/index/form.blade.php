@extends('admin.layouts.iframe')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3>基本表单</h3>
                </div>
                <div class="box-body">
                    <form action="" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">Input</label>
                            <div class="col-md-8">
                                <input type="text" name="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">Select</label>
                            <div class="col-md-8">
                                <select name="" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">Select2</label>
                            <div class="col-md-8">
                                <select name="" class="form-control select2" data-ajax-url="{{route('api.web.keywords_type')}}">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">Date</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">Date Time</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control datetime">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">File</label>
                            <div class="col-md-8">
                                <input type="file" class="form-control file-input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">File 预览</label>
                            <div class="col-md-8">
                                <input type="file" class="form-control file-input" data-initial-preview="https://colorhub.me/imgsrv/HV9LmR4DgWV2f8G7AqWapN,https://colorhub.me/imgsrv/a89cyUzdPhNnzAM6vRPTaB">
                                <p class="help-block">添加属性 <b>data-initial-preview="图片地址,图片地址"</b></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
            $('.file-input').fileinput({
                language: 'zh',
                showUpload: false,
                dropZoneEnabled: false,
                uploadAsync: false,
                fileActionSettings: {showRemove: false, showDrag: false},
                initialPreviewAsData: true,
                browseClass: 'btn bg-purple',
                initialPreviewDelimiter: ',',
            });
        })
    </script>
@endsection