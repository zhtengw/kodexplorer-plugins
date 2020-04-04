<!DOCTYPE html>
<html>
<head>
  <title>Basic WebViewer</title>
<!-- Import WebViewer as a script tag -->
<script src="<?php echo $this->pluginHost;?>static/lib/webviewer.min.js"></script>
</head>


<body>
  <div id='viewer' style='width: auto; height: 600px; margin: 0 auto;'></div>
  <script>
  WebViewer({
    path: "<?php echo $this->pluginHost;?>static/lib", // path to the PDFTron 'lib' folder on your server
    licenseKey: 'Insert commercial license key here after purchase',
    initialDoc: "<?php echo $fileUrl;?>",
    enableFilePicker: false,
  }, document.getElementById('viewer'))
  .then(instance => { 
    instance.setLanguage("<?php echo $lang;?>");
    if(<?php var_export($config['darktheme']); ?> == 1) {instance.setTheme('dark');}
    
    const { docViewer, annotManager, Annotations } = instance;
    // call methods from instance, docViewer and annotManager as needed

    docViewer.on('documentLoaded', () => {
    });
     // Add header button that will get file data on click
    instance.setHeaderItems(header => {
      header.push({
          type: 'actionButton',
          title: "<?php echo LNG('common.save'); ?>",
          img: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>',
          onClick: async () => {
            const doc = docViewer.getDocument();
            const xfdfString = await annotManager.exportAnnotations();
            const options = {
              xfdfString
            };
            const data = await doc.getFileData(options);
            const arr = new Uint8Array(data);
            const blob = new Blob([arr], { type: 'application/pdf' });

            // add code for handling Blob here
      
            var req = new XMLHttpRequest();
            req.open("POST", "<?php echo $this->pluginApi;?>save&path=<?php echo rawurlencode($path)?>");
            req.onload = function (oEvent) {
                // Uploaded.
            };
            req.send(blob);
            
          }
      });
    });
  });
</script>
</body>
</html>