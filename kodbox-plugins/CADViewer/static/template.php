<?php
function substring($str, $start, $len) {
     $tmpstr = "";
     $strlen = $start + $len;
     for($i = 0; $i < $strlen; $i++) {
         if(ord(substr($str, $i, 1)) > 0xa0) {
             $tmpstr .= substr($str, $i, 2);
             $i++;
         } else
             $tmpstr .= substr($str, $i, 1);
     }
     return $tmpstr.(strlen($str)>$len?"...":"");
}?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1, user-scalable=no" />
	<meta charset="utf-8">
	<link rel="stylesheet" href="<?php echo STATIC_PATH;?>style/skin/base/app_explorer.css?ver=<?php echo KOD_VERSION;?>"/>
	<title><?php echo substring($fileName,0,6);?> - <?php echo LNG('CADViewer.meta.title');?></title>
	<style>
	    iframe{position: absolute;left: 0;right: 0;top: 0;bottom: 0;z-index: 0;}
	    .loading{position: absolute;left: 0;right: 0;top: 0;bottom: 0;z-index: 1;background:rgba(255, 255, 255, 0.6);display: flex;justify-content: center;align-items: center;}
	    .loading .circle-border{width: 150px;height: 150px;padding: 3px;display: flex;justify-content: center;align-items: center;border-radius: 50%;background: linear-gradient(0deg, rgba(255, 255, 255, 0) 60%, rgb(131, 238, 255) 100%);animation: spin .8s linear 0s infinite;}
	    .loading .circle-border .circle-content{width: 100%;height: 100%;background-color: rgba(255, 255, 255, 0.6);border-radius: 50%;}
	    @keyframes spin {
          from {
            transform: rotate(0);
          }
          to{
            transform: rotate(359deg);
          }
        }
	</style>
</head>
    
    <body>
        <div class="loading"><div class="circle-border"><div class="circle-content"></div></div></div>
        <iframe onload="loaded()" src="<?php echo $data;?>" scrolling="no" width="100%" height="100%" frameborder="0" scrolling="no" allowfullscreen></iframe>
        <script type="text/javascript">
            function loaded(){
                setTimeout(function(){
                    document.getElementsByClassName('loading')[0].style.display="none";
                },2000)
            }
        </script>
    </body>
</html>
