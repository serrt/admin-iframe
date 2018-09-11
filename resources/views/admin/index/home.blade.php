@extends('admin.layouts.iframe')
@section('content')
<div class="row">
    <div class="col-md-3 col-xs-12">
        <div class="info-box bg-blue">
            <span class="info-box-icon"><i class="fa fa-apple"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">APP总数</span>
                <span class="info-box-number">{{$wechat_count}}</span>

                <span class="progress-description">APP总数</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xs-12">
        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">用户总数</span>
                <span class="info-box-number">{{$user_count}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-xs-12">
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-comment"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">资料总数</span>
                <span class="info-box-number">{{$message_count}}</span>
            </div>
        </div>
    </div>
</div>
@endsection
