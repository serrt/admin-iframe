<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | with iframe</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('admin.layouts.css')

    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
    <!-- 顶部 -->
    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>LT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Admin</b>LTE</span>
        </a>
        <!-- 顶部菜单 -->
        <nav class="navbar navbar-static-top">
            <!-- 隐藏左边菜单-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <!-- 右边部分 -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <!-- 打开右边隐藏的部分 -->
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-user"></i> User</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- 右边隐藏的部分 -->
    <aside class="control-sidebar control-sidebar-dark">
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active">
                <a href="#control-sidebar-skin" data-toggle="tab">
                    <i class="fa fa-wrench"></i>
                </a>
            </li>
            <li>
                <a href="#control-sidebar-password" data-toggle="tab">
                    <i class="fa fa-gears"></i>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="control-sidebar-skin">
                <h3 class="control-sidebar-heading">Skins</h3>
                @component('component.skins')
                @endcomponent
            </div>
            <div class="tab-pane" id="control-sidebar-password">
                <h3 class="control-sidebar-heading">Update Profile</h3>
                <form action="" method="post" autocomplete="off">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email">
                        <span class="fa fa-user-o form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password">
                        <span class="fa fa-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-6 col-xs-offset-6">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
        </div>
    </aside>
    <div class="control-sidebar-bg"></div>

    <!-- 左边菜单 js填充 -->
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
            </ul>
        </section>
    </aside>

    <!-- 多标签页 -->
    <div class="content-wrapper" id="content-wrapper" style="min-height: 421px;">
        <div class="content-tabs">
            <button class="roll-nav roll-left tabLeft" onclick="scrollTabLeft()">
                <i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs menuTabs tab-ui-menu" id="tab-menu">
                <div class="page-tabs-content" style="margin-left: 0px;">
                </div>
            </nav>
            <button class="roll-nav roll-right tabRight" onclick="scrollTabRight()">
                <i class="fa fa-forward" style="margin-left: 3px;"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown tabClose" data-toggle="dropdown">
                    页签操作<i class="fa fa-caret-down" style="padding-left: 3px;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" style="min-width: 128px;">
                    <li><a class="tabReload" href="javascript:refreshTab();">刷新当前</a></li>
                    <li><a class="tabCloseCurrent" href="javascript:closeCurrentTab();">关闭当前</a></li>
                    <li><a class="tabCloseAll" href="javascript:closeOtherTabs(true);">全部关闭</a></li>
                    <li><a class="tabCloseOther" href="javascript:closeOtherTabs();">除此之外全部关闭</a></li>
                </ul>
            </div>
            <button class="roll-nav roll-right fullscreen" onclick="App.handleFullScreen()"><i class="fa fa-arrows-alt"></i></button>
        </div>
        <div class="content-iframe">
            <div class="tab-content " id="tab-content">

            </div>
        </div>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.8
        </div>
        <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
        reserved.
    </footer>
</div>

@include('admin.layouts.js')
<!-- Slimscroll -->
<script src="{{asset('js/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('js/fastclick.js')}}"></script>

<!--tabs-->
<script src="{{asset('js/app_iframe.js')}}"></script>

<script type="text/javascript">

    $(function () {
        App.setbasePath("./");
        App.setGlobalImgPath("images/");

        var menus = JSON.parse('{!! $menus !!}');
        
        if (menus.length > 0) {
            var firstMenu = menus[0];
            if (!firstMenu.title) {
                firstMenu.title = firstMenu.text;
            }
            addTabs(firstMenu);
        }
        App.fixIframeCotent();

        $('.sidebar-menu').sidebarMenu({data: menus});
    });
</script>

</body>
</html>