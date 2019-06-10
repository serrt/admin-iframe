@extends('mp.layout')
@section('content')
    <div class="page js_show">
        <div class="page__hd">
            <div class="page__title">MP JSSDK</div>
            <div class="page__desc">测试</div>
        </div>
        <div class="page__bd page__bd_spacing">
            <div class="weui-cells">
                <a class="weui-cell weui-cell_access" href="{{route('mp.image')}}">
                    <div class="weui-cell__bd">
                        <p>图片</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
            </div>
        </div>
    </div>
@endsection