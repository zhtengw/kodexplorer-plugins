kodReady.push(function(){
	kodApp.add({
		name:"OnlyOffice",
		title:"{{LNG.OnlyOffice.meta.name}}",
		icon:'{{pluginHost}}static/images/icon.png',
		ext:"{{config.fileExt}}",
		sort:"{{config.fileSort}}",
		callback:function(path,ext){
			var url = '{{pluginApi}}&path='+core.pathCommon(path);
			if('window' == "{{config.openWith}}"){
				window.open(url);
			}else{
				core.openDialog(url,core.icon(ext),htmlEncode(core.pathThis(path)));
			}
		}
	});
	
	// 右键菜单：清空文档历史
    $.contextMenu.menuAdd({
        'clearHist': {
            name: "{{LNG.OnlyOffice.clear.title}}",
            className: "clearHist",
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
                    var url = '{{pluginApi}}&clearhist=1&path=' + core.pathCommon(path);
                    core.openDialog(url, core.icon(ext), "{{LNG.OnlyOffice.clear.title}}");
                    
                }
            }
        }
    },
        '.menu-file', '.remove', false);
        
    // OnlyOffice文档历史仅支持可编辑的文字文档，仅对于这些格式显示清空文档历史菜单
    Hook.bind("rightMenu.show.menu-file,rightMenu.show.menu-tree-file",
    function($menuAt, $theMenu) {
        var param = $(".context-menu-active").hasClass("menu-tree-file") ? ui.tree.makeParam() : ui.path.makeParam();
        var ext = core.pathExt(param.path);
        var allowExt = "doc,docx,dotx,html,odt,ott,rtf,txt";
        var hideClass = "hidden";

        if (inArray(allowExt.split(","), ext)) {
            $theMenu.find(".clearHist").removeClass(hideClass);
        } else {
            $theMenu.find(".clearHist").addClass(hideClass);
        }
    });
});
