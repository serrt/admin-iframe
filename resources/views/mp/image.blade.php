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
<script src="https://cdn.bootcss.com/vConsole/3.3.0/vconsole.min.js"></script>
<script type="text/javascript" charset="utf-8">
    var vConsole = new VConsole();
    wx.config(<?php echo $app->jssdk->buildConfig(array('chooseImage', 'previewImage', 'uploadImage', 'downloadImage'), false) ?>);
    wx.ready(function () {
        wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                console.log(localIds)
            }
        });
    });
</script>
@endsection