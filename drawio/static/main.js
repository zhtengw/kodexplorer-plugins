kodReady.push(function() {
    Events.bind('explorer.kodApp.before', function(appList) {
        appList.push({
		name:"drawio",
		title:"{{LNG['drawio.meta.name']}}",
		icon:'{{pluginHost}}static/images/icon.png',
		ext:"{{config.fileExt}}",
		sort:"{{config.fileSort}}",
			callback:function(){
				core.openFile('{{pluginApi}}',"{{config.openWith}}",_.toArray(arguments));
		}
	});
});
	
	$.contextMenu.menuAdd({
        'shareDraw': {
            name: "{{LNG['drawio.share.title']}}",
            className: "shareDraw",
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
                    var url = '{{pluginApi}}&share=1&path=' + core.pathCommon(path);
                    core.openFile('{{pluginApi}}', "dialog", "{{LNG['drawio.share.title']}}");
                }
            }
        }
    },
        '.menu-file', false, '.menu-share-path');

});
