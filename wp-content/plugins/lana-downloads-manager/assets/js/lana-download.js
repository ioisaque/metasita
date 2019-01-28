tinymce.PluginManager.add('lana_download', function (editor, url) {
    editor.addButton('lana_download', {
        tooltip: 'Download Shortcode',
        icon: 'lana-download',
        onclick: function () {

            jQuery.post(ajaxurl, {
                action: 'lana_downloads_manager_get_lana_download_list'
            }, function (response) {

                /** error */
                if (false === response['success']) {
                    alert(response['data']['message']);
                }

                /** success */
                if (true === response['success']) {
                    tinymce.activeEditor.windowManager.open({
                        title: 'Download',
                        url: url + '/../html/lana-download.html?v=' + response['data']['version'],
                        width: 480,
                        height: 180
                    }, {
                        lana_download_list: response['data']['lana_download_list']
                    });
                }
            });
        }
    });
});