@extends('mp.layout')
@section('content')
    <div class="page js_show">
        <div class="page__hd">
            <div class="page__title">图片</div>
            <div class="page__desc">处理图片</div>
        </div>
        <div class="page__bd page__bd_spacing">
            <div class="weui-cells weui-cells_form" id="uploader">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <div class="weui-uploader">
                            <div class="weui-uploader__hd">
                                <p class="weui-uploader__title">图片上传</p>
                                <div class="weui-uploader__info"><span id="uploadCount">0</span>/5</div>
                            </div>
                            <div class="weui-uploader__bd">
                                <ul class="weui-uploader__files" id="uploaderFiles"></ul>
                                <div class="weui-uploader__input-box">
                                    <input id="uploaderInput" class="weui-uploader__input" type="file" accept="image/*" capture="camera" multiple="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="https://res.wx.qq.com/open/js/jweixin-1.4.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $app->jssdk->buildConfig(array('chooseImage', 'previewImage', 'uploadImage', 'downloadImage'), true) ?>);
</script>
@endsection