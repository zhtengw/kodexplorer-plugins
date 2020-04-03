kodReady.push(function() {
    Events.bind('explorer.kodApp.before', function(appList) {
        appList.push({
            name: "bisheng",
            title: "{{LNG['bisheng.meta.name']}}",
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
    var viewByBisheng = {
            'viewAsPDF': {
                name: "{{LNG['bisheng.viewAsPDF']}}",
                className: "viewAsPDF",
                icon: "{{pluginHost}}static/images/icon.png",
                callback: function(action, option) {
                    var param = kodApp.pathAction.makeParamItem();
                    var path = param.path;
                    name = param.name;
                    ext = pathTools.pathExt(name);
                    var args = new Array(path, ext, name);
                    core.openFile('{{pluginApi}}', "dialog", args, 'viewtype=pdf');
                }
            }
        }
    // 右键菜单: 使用毕升预览
    var toPDFExt = "doc,docm,docx,dot,dotm,dotx,fodt,odt,fodp,odp,pot,potm,potx,pps,ppsm,ppsx,ppt,pptm,pptx,fods,ods,xls,xlsm,xlsx,xlt,xltm,xltx";
    Events.bind(
        'rightMenu.beforeShow@.menu-path-file', function(menu, menuType) {
        var name = kodApp.pathAction.makeParamItem().name;
        var ext = pathTools.pathExt(name);
        var allowExt = inArray(toPDFExt.split(","), ext);

        if (menu.extendViewAsPDF) {
            if (!allowExt) {
                $.contextMenu.menuItemHide(menu, 'viewAsPDF');
            } else {
                $.contextMenu.menuItemShow(menu, 'viewAsPDF');
            }
            return;
        } else {
            if (!allowExt) return;
        }
        $.contextMenu.menuAdd(viewByBisheng,
            menu, '.open-with', false);


        menu.extendViewAsPDF = true;
    });
    Events.bind(
        'rightMenu.beforeShow@.menu-path-guest-file', function(menu, menuType) {
        var name = kodApp.pathAction.makeParamItem().name;
        var ext = pathTools.pathExt(name);
        var allowExt = inArray(toPDFExt.split(","), ext);

        if (menu.extendViewAsPDF) {
            if (!allowExt) {
                $.contextMenu.menuItemHide(menu, 'viewAsPDF');
            } else {
                $.contextMenu.menuItemShow(menu, 'viewAsPDF');
            }
            return;
        } else {
            if (!allowExt) return;
        }
        $.contextMenu.menuAdd(viewByBisheng,menu, '.open-with', false);
        menu.extendViewAsPDF = true;
    });
    Events.bind(
        'rightMenu.beforeShow@.menu-simple-file', function(menu, menuType) {
        var name = kodApp.pathAction.makeParamItem().name;
        var ext = pathTools.pathExt(name);
        var allowExt = inArray(toPDFExt.split(","), ext);

        if (menu.extendViewAsPDF) {
            if (!allowExt) {
                $.contextMenu.menuItemHide(menu, 'viewAsPDF');
            } else {
                $.contextMenu.menuItemShow(menu, 'viewAsPDF');
            }
            return;
        } else {
            if (!allowExt) return;
        }
        $.contextMenu.menuAdd(viewByBisheng,menu, '.open-with', false);
        menu.extendViewAsPDF = true;
    });
    Events.bind(
        'rightMenu.beforeShow@.menu-tree-file', function(menu, menuType) {
        var name = kodApp.pathAction.makeParamItem().name;
        var ext = pathTools.pathExt(name);
        var allowExt = inArray(toPDFExt.split(","), ext);

        if (menu.extendViewAsPDF) {
            if (!allowExt) {
                $.contextMenu.menuItemHide(menu, 'viewAsPDF');
            } else {
                $.contextMenu.menuItemShow(menu, 'viewAsPDF');
            }
            return;
        } else {
            if (!allowExt) return;
        }
        $.contextMenu.menuAdd(viewByBisheng,menu, '.open-with', false);
        menu.extendViewAsPDF = true;
    });
});