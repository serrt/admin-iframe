<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.name')}} | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('admin.layouts.css')
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>{{config('app.name')}}</b></a>
        </div>

        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="{{route('admin.doLogin')}}" method="post" autocomplete="off">
                {{csrf_field()}}
                <div class="form-group has-feedback {{$errors->has('username')?'has-error':''}}">
                    <input type="text" name="username" class="form-control" placeholder="Username" value="{{old('username')?:'admin'}}" required>
                    <span class="fa fa-user form-control-feedback"></span>
                    @if($errors->has('username'))
                    <span class="help-block">{{$errors->first('username')}}</span>
                    @endif
                </div>
                <div class="form-group has-feedback {{$errors->has('password')?'has-error':''}}">
                    <input type="password" name="password" class="form-control" placeholder="Password" value="123456" required>
                    <span class="fa fa-lock form-control-feedback"></span>
                    @if($errors->has('password'))
                        <span class="help-block">{{$errors->first('password')}}</span>
                    @endif
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-xs-4 col-xs-offset-8">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    @include('admin.layouts.js')
</body>
</html>
