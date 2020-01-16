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

    // 右键菜单: 分享图表
    Events.bind(
        'rightMenu.beforeShow@.menu-path-file', function(menu, menuType) {
        if (menu.extendShareDraw) return;
        $.contextMenu.menuAdd({
            'shareDraw': {
                name: "{{LNG['drawio.share.title']}}",
                className: "shareDraw",
                icon: "{{pluginHost}}static/images/icon.png",
                callback: function(action, option) {
                    
                //alert(JSON.stringify(core.openFile));

                    //var path = core.makeParamItem;
                    //var args = new Array(path,'xml','this');
                    //alert(args);
                        //core.openFile('{{pluginApi}}', "dialog",  args, 'share=1');
                }
            }
        },
            menu, false, '.share');
        menu.extendShareDraw = true;
    });

    // 菜单：新建图表
    var newDrawMenu = {
        'newDraw': {
            name: "{{LNG['drawio.file.name']}}",
            className: "newDraw",
            icon: "{{pluginHost}}static/images/icon.png",
            callback: function() {
                //alert(JSON.stringify(core));
                //core.newFile('txt');
            }
        }
    }
    // 空白右键菜单
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
    // 工具栏“新建更多”菜单
    Events.bind(
        'rightMenu.beforeShow@.menu-toolbar-new-file-others', function(menu, menuType) {
        if (menu.extendNewDraw) return;
        $.contextMenu.menuAdd(newDrawMenu, menu, false, '.new-file-docx');
        menu.extendNewDraw = true;
    });
});