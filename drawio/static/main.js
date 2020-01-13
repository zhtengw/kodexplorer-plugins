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
    // 右键菜单：分享图表
    $.contextMenu.menuAdd({
        'shareDraw': {
            name: "{{LNG.drawio.share.title}}",
            className: "shareDraw",
            icon: "{{pluginHost}}static/images/icon.png",
            callback: function(action, option) {
                var path;
                if (action.path !== undefined) {
                    path = action.path;
                } else {
                    path = ui.path.makeParam().path;
                }
                if ( !! path) {
                    var param = $(".context-menu-active").hasClass("menu-tree-file") ? ui.tree.makeParam() : ui.path.makeParam();
                    var ext = core.pathExt(param.path);
                    var url = '{{pluginApi}}&share=1&path=' + core.pathCommon(path);
                    core.openDialog(url, core.icon(ext), "{{LNG.drawio.share.title}}");
                }
            }
        }
    },
        '.menu-file', false, '.share');
    // 对于非draw.io支持的文件格式，隐藏分享图表菜单
    Hook.bind("rightMenu.show.menu-file,rightMenu.show.menu-tree-file",
    function($menuAt, $theMenu) {
        var param = $(".context-menu-active").hasClass("menu-tree-file") ? ui.tree.makeParam() : ui.path.makeParam();
        var ext = core.pathExt(param.path);
        var allowExt = "{{config.fileExt}}";
        var hideClass = "hidden";

        if (inArray(allowExt.split(","), ext)) {
            $theMenu.find(".shareDraw").removeClass(hideClass);
        } else {
            $theMenu.find(".shareDraw").addClass(hideClass);
        }
    });
    
    // 右键菜单：新建图表
    $.contextMenu.menuAdd({
        'newDraw': {
            name: "{{LNG.drawio.file.name}}",
            className: "newDraw",
            icon: "{{pluginHost}}static/images/icon.png",
            callback: function() {
                ui.path.newFile('drawio');
            }
        }
    },
        '.menu-body-main', false, 'newfile-docx');
});