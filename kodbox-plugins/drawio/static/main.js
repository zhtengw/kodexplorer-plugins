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
            icon: "{{pluginHost}}static/images/drawio.png",
            callback: function() {
                //kodApp.pathAction.newFile('drawio');
                if(typeof(kodApp.root.pathAction)=="undefined"){ 
                    kodApp.pathAction.newFile('drawio');
                } else {
                    kodApp.root.pathAction.newFile('drawio');
                }
                //window.kodApp.root.pathAction.newFile('drawio');
                //alert(kodApp.root.pathAction.makeParamItem().name);
            }
        }
    }
    function menuLoad(menu, menuType) {
        if (menu.extendNewDraw) return;
        $.contextMenu.menuAdd(newDrawMenu, menu, false, '.new-file-docx');
        menu.extendNewDraw = true;
    }
    // 文件夹空白右键菜单
    Events.bind('rightMenu.beforeShow@.menu-path-body', menuLoad);
    // 桌面右键菜单
    Events.bind('rightMenu.beforeShow@.menu-desktop', menuLoad);
    // 本地路径目录空白右键菜单
    Events.bind('rightMenu.beforeShow@.menu-path-guest-body', menuLoad);
    // 工具栏“新建更多”菜单
    Events.bind('rightMenu.beforeShow@.menu-toolbar-new-file-others', menuLoad);
});