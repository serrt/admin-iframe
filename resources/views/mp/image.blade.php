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
                                <p class="weui-uploader__title">H5</p>
                                <div class="weui-uploader__info"><span id="uploadCount">0</span>/5</div>
                            </div>
                            <div class="weui-uploader__bd">
                                <ul class="weui-uploader__files" id="uploaderFiles">
                                    <li class="weui-uploader__file">
                                        <img src="{{asset('images/403.jpeg')}}" onclick="gallery(this)" alt="" width="100%" height="100%">
                                    </li>
                                </ul>
                                <div class="weui-uploader__input-box">
                                    <input id="uploader" class="weui-uploader__input" type="file" accept="image/*" capture="camera" multiple/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <div class="weui-uploader">
                            <div class="weui-uploader__hd">
                                <p class="weui-uploader__title">WS</p>
                                <div class="weui-uploader__info"><span id="uploadCount">0</span>/5</div>
                            </div>
                            <div class="weui-uploader__bd">
                                <ul class="weui-uploader__files" id="uploaderFiles">
                                    <li class="weui-uploader__file">
                                        <img src="{{asset('images/403.jpeg')}}" onclick="gallery(this)" alt="" width="100%" height="100%">
                                    </li>
                                </ul>
                                <div class="weui-uploader__input-box">
                                    <input class="weui-uploader__input" type="text" onclick="chooseImage()"/>
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
    function gallery (ele) {
        var bt = weui.gallery(ele.src, {
            onDelete: function(){
                // if(confirm('确定删除该图片？')){ console.log('删除'); }
                bt.hide();
            }
        })
    }
    function chooseImage () {
        wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                console.log(localIds)
            }
        });
    }
    wx.config(<?php echo $app->jssdk->buildConfig(array('chooseImage', 'previewImage', 'uploadImage', 'downloadImage'), false) ?>);

    var uploadCount = 0;
    weui.uploader('#uploader', {
        url: '{{route('api.web.upload')}}',
        auto: true,
        type: 'file',
        fileVal: 'fileVal',
        compress: {
            width: 1600,
            height: 1600,
            quality: .8
        },
        onBeforeQueued: function(files) {
            // `this` 是轮询到的文件, `files` 是所有文件

            if(["image/jpg", "image/jpeg", "image/png", "image/gif"].indexOf(this.type) < 0){
                weui.alert('请上传图片');
                return false; // 阻止文件添加
            }
            if(this.size > 10 * 1024 * 1024){
                weui.alert('请上传不超过10M的图片');
                return false;
            }
            if (files.length > 5) { // 防止一下子选择过多文件
                weui.alert('最多只能上传5张图片，请重新选择');
                return false;
            }
            if (uploadCount + 1 > 5) {
                weui.alert('最多只能上传5张图片');
                return false;
            }

            ++uploadCount;

            // return true; // 阻止默认行为，不插入预览图的框架
        },
        onQueued: function(){

            // console.log(this.status); // 文件的状态：'ready', 'progress', 'success', 'fail'
            // console.log(this.base64); // 如果是base64上传，file.base64可以获得文件的base64

            // this.upload(); // 如果是手动上传，这里可以通过调用upload来实现；也可以用它来实现重传。
            // this.stop(); // 中断上传

            // return true; // 阻止默认行为，不显示预览图的图像
        },
        onBeforeSend: function(data, headers){
            console.log(data);
            // $.extend(data, { test: 1 }); // 可以扩展此对象来控制上传参数
            // $.extend(headers, { Origin: 'http://127.0.0.1' }); // 可以扩展此对象来控制上传头部

            return false; // 阻止文件上传
        },
        onProgress: function(procent){
            console.log(this, procent);
            // return true; // 阻止默认行为，不使用默认的进度显示
        },
        onSuccess: function (ret) {
            console.log(this, ret);
            // return true; // 阻止默认行为，不使用默认的成功态
        },
        onError: function(err){
            console.log(this, err);
            // return true; // 阻止默认行为，不使用默认的失败态
        }
    });
</script>
@endsection