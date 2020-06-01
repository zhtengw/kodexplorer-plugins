kodReady.push(function() {
    Events.bind('explorer.kodApp.before', function(appList) {
        appList.push({
            name: "OnlyOffice",
            title: "{{LNG['OnlyOffice.meta.name']}}",
            icon: '{{pluginHost}}static/images/icon.png',
            ext: "{{config.fileExt}}",
            sort: "{{config.fileSort}}",
			callback:function(){
				core.openFile('{{pluginApi}}',"{{config.openWith}}",_.toArray(arguments));
            }
        });
    });
    
        
    function inArray(arr, val) {
        return arr.some(function(v) {
            return val === v;
        })
    }
    var clearHist = {
            'clearHist': {
                name: "{{LNG['OnlyOffice.clear.title']}}",
                className: "clearHist",
                icon: "{{pluginHost}}static/images/icon.png",
                callback: function(action, option) {
                    var param = kodApp.pathAction.makeParamItem();
                    var path = param.path;
                    name = param.name;
                    ext = pathTools.pathExt(name);
                    var args = new Array(path, ext, name);
                    core.openFile('{{pluginApi}}', "dialog", args, 'clearhist=1');
                }
            }
        }
    // 右键菜单：清空文档历史
    // OnlyOffice文档历史仅支持可编辑的文字文档，仅对于这些格式显示清空文档历史菜单
    var supportExt = "doc,docx,dotx,html,odt,ott,rtf,txt";
    Events.bind(
        'rightMenu.beforeShow@.menu-path-file', function(menu, menuType) {
        var name = kodApp.pathAction.makeParamItem().name;
        var ext = pathTools.pathExt(name);
        var allowExt = inArray(supportExt.split(","), ext);

        if (menu.extendClearHist) {
            if (!allowExt) {
                $.contextMenu.menuItemHide(menu, 'clearHist');
            } else {
                $.contextMenu.menuItemShow(menu, 'clearHist');
            }
            return;
        } else {
            if (!allowExt) return;
        }
        $.contextMenu.menuAdd(clearHist,
            menu, '.remove', false);


        menu.extendClearHist = true;
    });
    Events.bind(
        'rightMenu.beforeShow@.menu-path-guest-file', function(menu, menuType) {
        var name = kodApp.pathAction.makeParamItem().name;
        var ext = pathTools.pathExt(name);
        var allowExt = inArray(supportExt.split(","), ext);

        if (menu.extendClearHist) {
            if (!allowExt) {
                $.contextMenu.menuItemHide(menu, 'clearHist');
            } else {
                $.contextMenu.menuItemShow(menu, 'clearHist');
            }
            return;
        } else {
            if (!allowExt) return;
        }
        $.contextMenu.menuAdd(clearHist,menu, '.remove', false);
        menu.extendClearHist = true;
    });
    Events.bind(
        'rightMenu.beforeShow@.menu-simple-file', function(menu, menuType) {
        var name = kodApp.pathAction.makeParamItem().name;
        var ext = pathTools.pathExt(name);
        var allowExt = inArray(supportExt.split(","), ext);

        if (menu.extendClearHist) {
            if (!allowExt) {
                $.contextMenu.menuItemHide(menu, 'clearHist');
            } else {
                $.contextMenu.menuItemShow(menu, 'clearHist');
            }
            return;
        } else {
            if (!allowExt) return;
        }
        $.contextMenu.menuAdd(clearHist,menu, '.remove', false);
        menu.extendClearHist = true;
    });
    Events.bind(
        'rightMenu.beforeShow@.menu-tree-file', function(menu, menuType) {
        var name = kodApp.pathAction.makeParamItem().name;
        var ext = pathTools.pathExt(name);
        var allowExt = inArray(supportExt.split(","), ext);

        if (menu.extendClearHist) {
            if (!allowExt) {
                $.contextMenu.menuItemHide(menu, 'clearHist');
            } else {
                $.contextMenu.menuItemShow(menu, 'clearHist');
            }
            return;
        } else {
            if (!allowExt) return;
        }
        $.contextMenu.menuAdd(clearHist,menu, '.remove', false);
        menu.extendClearHist = true;
    });
});