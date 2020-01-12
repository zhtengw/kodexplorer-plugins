<?php

	if (isset($_POST['newcontent'])){
	    $newcontent = $_POST['newcontent'];
	    file_put_contents($path,$newcontent, LOCK_EX);

	    exit;
	}
?>
<!DOCTYPE html>
<html><title> Draw.io </title>
<head>
	<link rel="shortcut icon" href="<?php echo $this->pluginHost;?>static/images/icon.png">
	<style type="text/css">
		html, body, #wrapper {
			height:100%;
			width:100%;
			margin:0;
			padding:0;
			border:0;
		}
		table#wrapper {
			height:75%;
		}
		#wrapper td {
			vertical-align:middle;
			text-align:center;
		}
		iframe {
			border:0;
			position:fixed;
			top:0;
			left:0;
			right:0;
			bottom:0;
			width:100%;
			height:100%
		}
	</style>

</head>
<body>
    	<script type="text/javascript">
		var editor = <?php var_export($serverAddr); ?>;
		var newfile = <?php var_export($newfile); ?>;
		var autosave = <?php var_export($config['autoSave']); ?>;
		
        // json messages refer: https://desk.draw.io/support/solutions/articles/16000042544-how-does-embed-mode-work-
		function edit(file)
		{
			var iframe = document.createElement('iframe');
			iframe.setAttribute('frameborder', '0');

			var close = function()
			{
				window.removeEventListener('message', receive);
				document.body.removeChild(iframe);
			};
			
			var receive = function(evt)
			{
				if (evt.data.length > 0)
				{
					var msg = JSON.parse(evt.data);
					
					if (msg.event == 'init')
					{
						if (newfile)
						{
						    iframe.contentWindow.postMessage(JSON.stringify({action: 'template'}),'*');
						}
						else
						{
							iframe.contentWindow.postMessage(JSON.stringify({action: 'load',
							    autosave: <?php var_export($config['autoSave']); ?>, xml: file}),'*');
						}
					}
					else if (msg.event == 'export')
					{

						close();
					}
					else if (msg.event == 'autosave')
					{					    
					    iframe.contentWindow.postMessage(JSON.stringify({action: 'status',
							    message: "<?php echo LNG('loading'); ?>", modified: true}),'*');
					    $.ajax({
					        type: 'post',
					        data: {newcontent: msg.xml},
					        success: function(){
					            iframe.contentWindow.postMessage(JSON.stringify({action: 'status',
							    message: "<?php echo LNG('save_success'); ?>", modified: false}),'*');
					        }
					    });

					}
					else if (msg.event == 'save')
					{
					    iframe.contentWindow.postMessage(JSON.stringify({action: 'spinner',
							    message: "<?php echo LNG('loading'); ?>", show: true, enabled: false}),'*');
					    $.ajax({
					        type: 'post',
					        data: {newcontent: msg.xml},
					        success: function(){
					            iframe.contentWindow.postMessage(JSON.stringify({action: 'spinner',
							    message: '', show: false}),'*');
					            
					            iframe.contentWindow.postMessage(JSON.stringify({action: 'spinner',
							    message: "<?php echo LNG('save_success'); ?>", show: true}),'*');
					            
					            setTimeout(function() {
					                iframe.contentWindow.postMessage(JSON.stringify({action: 'spinner',
							    message: '', show: false}),'*');
					            }, 500);
					        },
					        error: function(){
					            alert('Save failed!');
					        }
					    });
					}
					else if (msg.event == 'exit')
					{
	
						close();
					}
				}
			};

			window.addEventListener('message', receive);
			iframe.setAttribute('src', editor);
			document.body.appendChild(iframe);
		};
		
		edit(<?php var_export($content); ?>);
	</script>
	<script src="<?php echo STATIC_PATH;?>js/lib/jquery-1.8.0.min.js"></script>

</body>
</html>