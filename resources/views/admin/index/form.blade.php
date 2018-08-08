@extends('admin.layouts.iframe')
@section('content')
<div class="row">
    <div class="col-lg-6">
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
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
