<?php
    $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
    $dir = explode('/',__DIR__);
    $pre = $http_type.$_SERVER['HTTP_HOST'].substr(__DIR__,strlen($_SERVER["DOCUMENT_ROOT"]));
    function jsAPI(){ // js api 地址
        // docker run -i -t -d -p 666:80 onlyoffice/documentserver
        if (strpos($_GET['api'],"api.js")) {
            echo $_GET['api'];
        } else {
            echo 'http://'.$_GET['api'].'/web-apps/apps/api/documents/api.js';
        }
    }
    function uniqidKey(){ // 文件唯一值，用于表示是否同时编辑文档
        echo md5_file($_GET['path']);
    }
    function pathFile(){ // 本地硬盘路径转下载路径
        echo $GLOBALS["pre"]."/file.php?path=".$_GET['path'];
    }
    function cbUrl(){ // 文件保存回调
        echo $GLOBALS["pre"]."/save.php?path=".$_GET['path'];
    }
    function fileInfo($type){ // 获取文件名，后缀
        echo pathinfo($_GET['path'],$type);
    }
    function wpsType(){
        $type = strtolower(pathinfo($_GET['path'], PATHINFO_EXTENSION));
        $w = array("doc", "docm", "docx", "dot", "dotm", "dotx", "epub", "fodt", "htm", "html", "mht", "odt", "pdf", "rtf", "txt", "djvu", "xps");
        $p = array("fodp", "odp", "pot", "potm", "potx", "pps", "ppsm", "ppsx", "ppt", "pptm", "pptx");
        $s = array("csv", "fods", "ods", "xls", "xlsm", "xlsx", "xlt", "xltm", "xltx");
        if (in_array($type,$w)) {
            echo "text";
        } elseif (in_array($type,$p)){
            echo "presentation";
        } elseif (in_array($type,$s)){
            echo "spreadsheet";
        } else {
            echo "unkonwn";
        }
    }
?>
<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ONLYOFFICE Api Documentation</title>
</head>
<body style="height: 100%; margin: 0;">
    <div id="placeholder" style="height: 100%"></div>
    <script type="text/javascript" src=<?php jsAPI(); ?>></script>

    <script type="text/javascript">

        window.docEditor = new DocsAPI.DocEditor("placeholder",
            {
                "document": {
                    "fileType": "<?php fileInfo(PATHINFO_EXTENSION); ?>",
                    "key": "<?php uniqidKey(); ?>",
                    "title": "<?php fileInfo(PATHINFO_BASENAME); ?>",
                    "url": "<?php pathFile(); ?>",
                },
                "documentType": "<?php wpsType(); ?>",
                "editorConfig": {
                    "callbackUrl": "<?php cbUrl(); ?>",
                    "lang": "zh-CN",
                },
                "height": "100%",
                "width": "100%"
            });

    </script>
</body>
</html>