$(function () {
    // Skin switcher
    var currentSkin = 'skin-black-light';

    $('#layout-skins-list [data-skin]').click(function (e) {
        e.preventDefault()
        var skinName = $(this).data('skin')
        $('body').removeClass(currentSkin)
        $('body').addClass(skinName)
        currentSkin = skinName
    });

    $('.date').datepicker({
        autoclose: true,
        clearBtn: true,
        format: 'yyyy-mm-dd',
        language: 'zh-CN'
    });

    $('.datetime').datetimepicker({
        autoclose: true,
        clearBtn: true,
        format: 'yyyy-mm-dd hh:ii:ss',
        language: 'zh-CN'
    });
});