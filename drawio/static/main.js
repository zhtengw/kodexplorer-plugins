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
    var shareDrawMenu = {
            'shareDraw': {
                name: "{{LNG['drawio.share.title']}}",
                className: "shareDraw",
                icon: "{{pluginHost}}static/images/icon.png",
                callback: function(action, option) {
                    var param = kodApp.pathAction.makeParamItem();
                    var path = param.path;
                    var name = param.name;
                    var ext = pathTools.pathExt(name);
                    var args = new Array(path, ext, name);
                    core.openFile('{{pluginApi}}', "dialog", args, 'share=1');
                }
            }
        }
    // 右键菜单: 分享图表
    Events.bind(
        'rightMenu.beforeShow@.menu-path-file', function(menu, menuType) {
        var name = kodApp.pathAction.makeParamItem().name;
        var ext = pathTools.pathExt(name);
        var allowExt = inArray("{{config.fileExt}}".split(","), ext);

        if (menu.extendShareDraw) {
            if (!allowExt) {
                $.contextMenu.menuItemHide(menu, 'shareDraw');
            } else {
                $.contextMenu.menuItemShow(menu, 'shareDraw');
            }
            return;
        } else {
            if (!allowExt) return;
        }
        $.contextMenu.menuAdd(shareDrawMenu,menu, false, '.share');
        menu.extendShareDraw = true;
    });
    Events.bind(
        'rightMenu.beforeShow@.menu-path-guest-file', function(menu, menuType) {
        var name = kodApp.pathAction.makeParamItem().name;
        var ext = pathTools.pathExt(name);
        var allowExt = inArray("{{config.fileExt}}".split(","), ext);

        if (menu.extendShareDraw) {
            if (!allowExt) {
                $.contextMenu.menuItemHide(menu, 'shareDraw');
            } else {
                $.contextMenu.menuItemShow(menu, 'shareDraw');
            }
            return;
        } else {
            if (!allowExt) return;
        }
        $.contextMenu.menuAdd(shareDrawMenu,menu, '.open-with', false);
        menu.extendShareDraw = true;
    });
    Events.bind(
        'rightMenu.beforeShow@.menu-simple-file', function(menu, menuType) {
        var name = kodApp.pathAction.makeParamItem().name;
        var ext = pathTools.pathExt(name);
        var allowExt = inArray("{{config.fileExt}}".split(","), ext);

        if (menu.extendShareDraw) {
            if (!allowExt) {
                $.contextMenu.menuItemHide(menu, 'shareDraw');
            } else {
                $.contextMenu.menuItemShow(menu, 'shareDraw');
            }
            return;
        } else {
            if (!allowExt) return;
        }
        $.contextMenu.menuAdd(shareDrawMenu,menu, false, '.share');
        menu.extendShareDraw = true;
    });

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