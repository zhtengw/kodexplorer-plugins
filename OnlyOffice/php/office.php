<?php
    $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
    $pre = $http_type.$_SERVER['HTTP_HOST'].substr(__DIR__,strlen($_SERVER["DOCUMENT_ROOT"]));
    $pathFile = $pre."/file.php?path=".$_GET['path'];
    $cbUrl = $pre."/save.php?path=".$_GET['path'];
    function fileInfo($type){ // 获取文件名，后缀
        return pathinfo($_GET['path'],$type);
    }
    function wpsType(){
        $type = strtolower(pathinfo($_GET['path'], PATHINFO_EXTENSION));
        $w = array("doc", "docm", "docx", "dot", "dotm", "dotx", "epub", "fodt", "htm", "html", "mht", "odt", "pdf", "rtf", "txt", "djvu", "xps");
        $p = array("fodp", "odp", "pot", "potm", "potx", "pps", "ppsm", "ppsx", "ppt", "pptm", "pptx");
        $s = array("csv", "fods", "ods", "xls", "xlsm", "xlsx", "xlt", "xltm", "xltx");
        if (in_array($type,$w)) {
            return "text";
        } elseif (in_array($type,$p)){
            return "presentation";
        } elseif (in_array($type,$s)){
            return "spreadsheet";
        } else {
            return "unkonwn";
        }
    }
?>
<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ONLYOFFICE Document Server</title>
</head>
<body style="height: 100%; margin: 0;">
    <div id="placeholder" style="height: 100%"></div>
    <script type="text/javascript" src=<?php echo $_GET['api']; ?>></script>

    <script type="text/javascript">

        window.docEditor = new DocsAPI.DocEditor("placeholder",
            {
                "document": {
                    "fileType": "<?php echo fileInfo(PATHINFO_EXTENSION); ?>",
                    "key": "<?php echo md5_file($_GET['path']); ?>",
                    "title": " ",//<?php echo fileInfo(PATHINFO_BASENAME); ?>",
                    "url": "<?php echo $pathFile; ?>",
                },
                "documentType": "<?php echo wpsType(); ?>",
                "editorConfig": {
                    "callbackUrl": "<?php echo $cbUrl; ?>",
                    "lang": "zh-CN",
                    "customization": {
                        "chat": false,
                        "commentAuthorOnly": false,
                        "comments": false,
                        "compactHeader": true,
                        "compactToolbar": false,
                        "help": false,
                        "toolbarNoTabs": false,
                    },
                },
                "height": "100%",
                "width": "100%"
            });

    </script>
</body>
</html>