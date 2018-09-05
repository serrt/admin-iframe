@extends('admin.layouts.iframe')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <form action="" class="form-horizontal" autocomplete="off">
                <div class="form-group">
                    <div class="col-md-2 control-label">名称</div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="name" value="{{request('name')}}" placeholder="名称">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        <a href="{{route('admin.user.create')}}" class="btn btn-default"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="box-body row">
            @foreach($list as $item)
                <div class="col-lg-3 col-xs-6">
                    <a href="" class="small-box bg-green">
                        <div class="inner">
                            <h3>{{$item->name}}</h3>

                            <p>{{$item->role->name}}</p>
                        </div>
                        <div class="icon img-responsive">
                            @if($item->logo)
                            <img src="https://colorhub.me/imgsrv/2ruY7FZBY9JQSNJwXmheXV" alt="" width="75">
                            @else
                            <i class="fa fa-wechat"></i>
                            @endif
                        </div>
                        <div class="small-box-footer">
                            更多信息 <i class="fa fa-arrow-circle-right"></i>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="box-footer clearfix">
            {{$list->appends(request()->all())->links()}}
        </div>
    </div>
@endsection