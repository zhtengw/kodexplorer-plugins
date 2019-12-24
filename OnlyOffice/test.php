<?php
$path = $_GET['path'];
echo "文件路径: ".$path;
echo "<br/>";
echo "是否存在: ".(file_exists($path)==true?"是":"否");
echo "<br/>";
$type = strtolower(pathinfo($path, PATHINFO_EXTENSION));
echo "文件名: ".pathinfo($path,PATHINFO_BASENAME);
echo "<br/>";
$w = array("doc", "docm", "docx", "dot", "dotm", "dotx", "epub", "fodt", "htm", "html", "mht", "odt", "pdf", "rtf", "txt", "djvu", "xps");
$p = array("fodp", "odp", "pot", "potm", "potx", "pps", "ppsm", "ppsx", "ppt", "pptm", "pptx");
$s = array("csv", "fods", "ods", "xls", "xlsm", "xlsx", "xlt", "xltm", "xltx");
if (in_array($type,$w)) {
    echo "类型: 文档"     .$type;
} elseif (in_array($type,$p)){
    echo "类型: 幻灯片".$type;
} elseif (in_array($type,$s)){
    echo "类型: 表格".$type;
} else {
    echo "类型: 无法识别后缀名类型!";
}
echo "<br/>";
$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
echo "域名: ".$http_type.$_SERVER['HTTP_HOST'];
echo "<br/>";
echo "URI: ".__DIR__."<br/>";
echo "浏览器UA: ".$_SERVER["HTTP_USER_AGENT"]."<br/>";
echo "网站根目录: ".$_SERVER["DOCUMENT_ROOT"]."<br/>";
echo "插件目录: ".substr(__DIR__,strlen($_SERVER["DOCUMENT_ROOT"]))."<br/>";
echo "下载地址: ".$http_type.$_SERVER['HTTP_HOST'].substr(__DIR__,strlen($_SERVER["DOCUMENT_ROOT"])).'/file.php?path='.$path;
?>