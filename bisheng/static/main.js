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
            name: "转成PDF查看",
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
        var allowExt = "{{config.fileExt}}";
        var hideClass = "hidden";

        //if (inArray(allowExt.split(","), ext)) {
        //    $theMenu.find(".viewAsPDF").removeClass(hideClass);
        //} else {
            $theMenu.find(".viewAsPDF").addClass(hideClass);
        //}
    });

});