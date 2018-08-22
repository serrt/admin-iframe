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
                            <div class="col-md-8 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3>文件上传</h3>
                </div>
                <div class="box-body">
                    <form action="{{route('admin.index.form_upload')}}" method="post" class="form-horizontal"
                          role="form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">单个文件</label>
                            <div class="col-md-8">
                                <input type="file" name="file" class="form-control file-input1" data-initial-preview="{{$img_url}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">多个文件上传</label>
                            <div class="col-md-8">
                                <input type="file" name="files[]" class="form-control file-input2" data-initial-preview="{{$imgs_url}}" multiple>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
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
                fileActionSettings: {showRemove: false, showDrag: false},
                initialPreviewAsData: true,
                browseClass: 'btn bg-purple',
            });
            $('.file-input2').fileinput({
                language: 'zh',
                showUpload: false,
                uploadAsync: false,
                fileActionSettings: {showRemove: false, showDrag: false},
                initialPreviewAsData: true,
                initialPreviewDelimiter: ',',
                browseClass: 'btn bg-purple'
            });
        })
    </script>
@endsection