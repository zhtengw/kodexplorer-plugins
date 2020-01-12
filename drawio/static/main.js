kodReady.push(function() {
    kodApp.add({
        name: "drawio",
        title: "{{LNG.drawio.meta.name}}",
        icon: '{{pluginHost}}static/images/icon.png',
        ext: "{{config.fileExt}}",
        sort: "{{config.fileSort}}",
        callback: function(path, ext) {
            var url = '{{pluginApi}}&path=' + core.pathCommon(path);
            if ('window' == "{{config.openWith}}") {
                window.open(url);
            } else {
                core.openDialog(url, core.icon(ext), htmlEncode(core.pathThis(path)));
            }
        }
    });
    $.contextMenu.menuAdd({
        'newDraw': {
            name: "新建图表",
            className: "newDraw",
            icon: "{{pluginHost}}static/images/icon.png",
            callback: function(action, option) {
                var path;
                // Todo；
                // function to get dir path;
                // make new xml file;
                // path = dir_path/newfile.xml
                if (action.path !== undefined) {
                    path = action.path;
                } else {
                    path = ui.path.makeParam().path;
                }
                if ( !! path) {

                    var param = $(".context-menu-active").hasClass("menu-tree-file") ? ui.tree.makeParam() : ui.path.makeParam();
                    var ext = core.pathExt(param.path);
                    var url = '{{pluginApi}}&newfile=1&path=' + core.pathCommon(path);
                    if ('window' == "{{config.openWith}}") {
                        window.open(url);
                    } else {
                        core.openDialog(url, core.icon(ext), htmlEncode(core.pathThis(path)));
                    }
                }
            }
        }
    },
        '.menu-body-main', false, '.newfile');
});