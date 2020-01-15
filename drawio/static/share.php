<!DOCTYPE html>
<html>
    <title>Share Draw.io Diagrams</title>
    
    <head>
        <link rel="shortcut icon" href="<?php echo $this->pluginHost;?>static/images/icon.png">
        <style type="text/css">
            div {text-align:center;}
            p {color:blue;}
            textarea {border:0;border-radius:5px;background-color:rgba(241,241,241,.98);width: 855px;height: 400px;padding: 10px;}
        </style>
    </head>
    
    <body>
        <script type="text/javascript">
        function getDiag(xmlFile) {

            var xmlDoc;
            var message;
            try {
                if (typeof window.DOMParser != "undefined") {
                    xmlhttp = new XMLHttpRequest();
                    xmlhttp.open("GET", xmlFile, false);
                    if (xmlhttp.overrideMimeType) {
                        xmlhttp.overrideMimeType('text/xml');
                    }
                    xmlhttp.send();
                    xmlDoc = xmlhttp.responseXML;
                } else {
                    xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
                    xmlDoc.async = "false";
                    xmlDoc.load(xmlFile);
                }
                var diagrams = xmlDoc.getElementsByTagName('diagram');
                if (diagrams.length > 0) {
                    var data = diagrams[0].childNodes[0].nodeValue;
                    var url = "https://www.draw.io/?lightbox=1&highlight=0000ff&edit=_blank&layers=1&nav=1#R" + data;
                    message = '<div><h2>' + "<?php echo LNG('drawio.share.url'); ?>" + '</h2>';
                    message += '<textarea>' + url + '</textarea></div>';
                } else {
                    message = '<div><h3>No diagrams data found!</h3></div>';
                }
            } catch (e) {
                message = '<div><h3>Not a draw.io xml file!</h3></div>';
            }
            return message;
        }
        var message = getDiag("<?php echo $fileUrl; ?>");

        document.write(message);
        </script>
    </body>

</html>