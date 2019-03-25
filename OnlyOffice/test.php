<?php
$src = $_GET['src'];
echo $src;
echo "<br/>";
echo $_SERVER['SERVER_NAME'];
echo "<br/>";
$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
echo $http_type;
echo "<br/>";
$find = strpos($src,"/data/User/");
echo $find;
echo "<br/>";
$path = $http_type . $_SERVER['SERVER_NAME'] . substr($src,$find);
echo $path;
echo "<br/>";
$type = strtolower(pathinfo($src, PATHINFO_EXTENSION));
echo $type;
echo "<br/>";
echo pathinfo($src,PATHINFO_BASENAME);
echo "<br/>";
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
// echo array_search($type,$w);
?>