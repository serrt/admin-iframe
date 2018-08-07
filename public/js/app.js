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

    $('.select2').select2({
        language: "zh-CN",
        allowClear: true,
        placeholder: '请选择',
        dataType: 'json',
        ajax: {
            delay: 2000,
            data: function (params) {
                return {
                    name: params.term,
                    page: params.page || 1
                };
            },
            escapeMarkup: function (markup) { return markup; },
            processResults: function (data) {
                var dataList = [
                    { id: 0, text: 'enhancement' },
                    { id: 1, text: 'bug' },
                    { id: 2, text: 'duplicate' },
                    { id: 3, text: 'invalid' },
                    { id: 4, text: 'wontfix' }
                ];
                return {
                    results: dataList,
                    pagination: {
                        more: data.meta?data.meta.current_page < data.meta.last_page:false
                    }
                };
            },
            minimumInputLength: 2,
            templateResult: function (repo) {
                console.log('templateResult');
                return repo.id
            },
            templateSelection: function (repo) {
                console.log('templateSelection');
                return repo.name
            },
            formatResult: function (repo) {
                console.log('formatResult');
                return repo.id
            },
            formatSelection: function () {
                console.log('formatSelection');
                return repo.name
            }
        }
    });
});