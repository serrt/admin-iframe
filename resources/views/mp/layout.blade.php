<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,viewport-fit=cover">
    <title>JS</title>
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.3/weui.min.css">
    <link rel="stylesheet" href="{{asset('css/mp-example.css')}}">
</head>
<body>
<div class="container" id="container">
    @yield('content')

</div>
<script type="text/javascript" src="https://res.wx.qq.com/open/libs/weuijs/1.1.4/weui.min.js"></script>
@yield('script')
</body>
</html>