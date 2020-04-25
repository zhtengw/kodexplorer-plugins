kodReady.push(function() {
    Events.bind('explorer.kodApp.before', function(appList) {
        appList.push({
            name: "PDFTron",
            title: "{{LNG['PDFTron.meta.name']}}",
            icon: '{{pluginHost}}static/images/icon.png',
            ext: "{{config.fileExt}}",
            sort: "{{config.fileSort}}",
            callback: function() {
                core.openFile('{{pluginApi}}', "{{config.openWith}}", _.toArray(arguments));
            }
        });
    });
});