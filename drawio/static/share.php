<!DOCTYPE html>
<html>
    <title>Share Draw.io Diagrams</title>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo $this->pluginHost;?>static/images/icon.png">
        <style type="text/css">
        textarea {
            border:0;
            border-radius:5px;
            background-color:rgba(241, 241, 241, .98);
            width: 60%;
            height: 100%;
            padding: 10px;
        }
        </style>
        <script type="text/javascript">
        function getDiag() {
            var xmlFile = "<?php echo $fileUrl; ?>";
            var shareUrl;
            var xmlDoc;
            var page = document.getElementById('page');
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
                    shareUrl = "https://www.draw.io/?lightbox=1&highlight=0000ff&edit=_blank&layers=1&nav=1#R" + data;

                    genHTML(page, shareUrl);

                } else {
                    page.innerHTML = '<h3>No diagrams data found!</h3>';
                }
            } catch (e) {
                page.innerHTML = '<h3>Not a draw.io xml file!</h3>';
            }
        }

        function copyUrl() {
            var url = document.getElementById("shareUrl");
            url.select();
            document.execCommand("Copy");
            url.unselect();
        }

        function viewUrl() {
            var url = document.getElementById("shareUrl").innerHTML;
            window.open(url);
        }

        function genHTML(page, shareUrl) {

            page.innerHTML = "<h2><?php echo LNG('drawio.share.url'); ?></h2>"
            // Add url textarea
            var textarea = document.createElement('textarea');
            textarea.setAttribute('id', 'shareUrl');
            textarea.setAttribute('readonly', 'readonly');
            textarea.innerHTML = shareUrl;
            page.appendChild(textarea);

            var br = document.createElement('div');
            br.innerHTML = "<br/>";
            page.appendChild(br);

            var cpbtn = document.createElement('input');
            cpbtn.setAttribute('type', 'button');
            cpbtn.setAttribute('onclick', "copyUrl();");
            cpbtn.setAttribute('value', "<?php echo LNG('copy'); ?>");
            page.appendChild(cpbtn);

            var space = document.createElement('span');
            space.setAttribute('style', 'display:inline-block;width:5%;');
            page.appendChild(space);

            var prebtn = document.createElement('input');
            prebtn.setAttribute('type', 'button');
            prebtn.setAttribute('onclick', "viewUrl();");
            prebtn.setAttribute('value', "<?php echo LNG('preview'); ?>");
            page.appendChild(prebtn);

        }
        </script>
    </head>
    
    <body onload="getDiag();">
        <div id='page' style="text-align:center;height: 300px;"></div>
    </body>

</html>