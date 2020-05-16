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
    
    // 菜单：新建图表
    var newDrawMenu = {
        'newDraw': {
            name: "{{LNG.drawio.file.name}}",
            className: "newDraw",
            icon: "{{pluginHost}}static/images/icon.png",
            callback: function() {
                ui.path.newFile('drawio');
            }
        }
    }
    // 空白右键菜单
    $.contextMenu.menuAdd(newDrawMenu, '.menu-body-main', false, 'newfile-docx');
    // 工具栏“新建更多”菜单
    $.contextMenu.menuAdd(newDrawMenu, ".tool-path-newfile", false, "newfile-docx");
});