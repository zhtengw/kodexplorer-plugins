kodReady.push(function() {
    kodApp.add({
        name: "bisheng",
        title: "{{LNG.bisheng.meta.name}}",
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
        'viewAsPDF': {
            name: "{{LNG.bisheng.viewAsPDF}}",
            className: "viewAsPDF",
            icon: "{{pluginHost}}static/images/icon.png",
            callback: function(action, option) {
                var path;
                if (action.path !== undefined) {
                    path = action.path;
                } else {
                    path = ui.path.makeParam().path;
                }
                var param = $(".context-menu-active").hasClass("menu-tree-file") ? ui.tree.makeParam() : ui.path.makeParam();
                var ext = core.pathExt(param.path);
                var url = '{{pluginApi}}&viewtype=pdf&path=' + core.pathCommon(path);
                if ('window' == "{{config.openWith}}") {
                    window.open(url);
                } else {
                    core.openDialog(url, core.icon(ext), htmlEncode(core.pathThis(path)));
                }
            }
        }
    },
    '.menu-file', false, '.down');
    Hook.bind("rightMenu.show.menu-file,rightMenu.show.menu-tree-file",
    function($menuAt, $theMenu) {
        var param = $(".context-menu-active").hasClass("menu-tree-file") ? ui.tree.makeParam() : ui.path.makeParam();
        var ext = core.pathExt(param.path);
        var allowExt = "doc,docm,docx,dot,dotm,dotx,fodt,odt,fodp,odp,pot,potm,potx,pps,ppsm,ppsx,ppt,pptm,pptx,fods,ods,xls,xlsm,xlsx,xlt,xltm,xltx";
        var hideClass = "hidden";

        if (inArray(allowExt.split(","), ext)) {
            $theMenu.find(".viewAsPDF").removeClass(hideClass);
        } else {
            $theMenu.find(".viewAsPDF").addClass(hideClass);
        }
    });

});