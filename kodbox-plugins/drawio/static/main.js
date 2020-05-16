kodReady.push(function() {
    Events.bind('explorer.kodApp.before', function(appList) {
        appList.push({
            name: "drawio",
            title: "{{LNG['drawio.meta.name']}}",
            icon: '{{pluginHost}}static/images/icon.png',
            ext: "{{config.fileExt}}",
            sort: "{{config.fileSort}}",
            callback: function() {
                core.openFile('{{pluginApi}}', "{{config.openWith}}", _.toArray(arguments));
            }
        });
    });

    function inArray(arr, val) {
        return arr.some(function(v) {
            return val === v;
        })
    }
    // 菜单：新建图表
    var newDrawMenu = {
        'newDraw': {
            name: "{{LNG['drawio.file.name']}}",
            className: "newDraw",
            icon: "{{pluginHost}}static/images/icon.png",
            callback: function() {
                kodApp.pathAction.newFile('drawio');
            }
        }
    }
    // 文件夹空白右键菜单
    Events.bind(
        'rightMenu.beforeShow@.menu-path-body', function(menu, menuType) {
        if (menu.extendNewDraw) return;
        $.contextMenu.menuAdd(newDrawMenu, menu, false, '.new-file-docx');
        menu.extendNewDraw = true;
    });
    // 桌面右键菜单
    Events.bind(
        'rightMenu.beforeShow@.menu-desktop', function(menu, menuType) {
        if (menu.extendNewDraw) return;
        $.contextMenu.menuAdd(newDrawMenu, menu, false, '.new-file-docx');
        menu.extendNewDraw = true;
    });
    // 本地路径目录空白右键菜单
    Events.bind(
        'rightMenu.beforeShow@.menu-path-guest-body', function(menu, menuType) {
        if (menu.extendNewDraw) return;
        $.contextMenu.menuAdd(newDrawMenu, menu, false, '.new-file-docx');
        menu.extendNewDraw = true;
    });
    // 工具栏“新建更多”菜单
    Events.bind(
        'rightMenu.beforeShow@.menu-toolbar-new-file-others', function(menu, menuType) {
        if (menu.extendNewDraw) return;
        $.contextMenu.menuAdd(newDrawMenu, menu, false, '.new-file-docx');
        menu.extendNewDraw = true;
    });
});