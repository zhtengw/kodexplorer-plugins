<?php

echo "文件路径: ".$path;
echo "<br/>";
echo "是否存在: ".(file_exists($path)==true?"是":"否");
echo "<br/>";
echo "文件名: ".pathinfo($path,PATHINFO_BASENAME);
echo "<br/>";
$w = array("doc", "docm", "docx", "dot", "dotm", "dotx", "epub", "fodt", "htm", "html", "mht", "odt", "pdf", "rtf", "txt", "djvu", "xps");
$p = array("fodp", "odp", "pot", "potm", "potx", "pps", "ppsm", "ppsx", "ppt", "pptm", "pptx");
$s = array("csv", "fods", "ods", "xls", "xlsm", "xlsx", "xlt", "xltm", "xltx");
if (in_array($fileExt,$w)) {
    echo "类型: 文档".$type;
} elseif (in_array($fileExt,$p)){
    echo "类型: 幻灯片".$fileExt;
} elseif (in_array($fileExt,$s)){
    echo "类型: 表格".$fileExt;
} else {
    echo "类型: 无法识别后缀名类型!";
}
echo "<br/>";

echo "域名: ".$this->pluginHost;
echo "<br/>";
echo "浏览器UA: ".$_SERVER["HTTP_USER_AGENT"]."<br/>";
echo "网站根目录: ".$_SERVER["DOCUMENT_ROOT"]."<br/>";
echo "插件目录: ".$this->pluginPath."<br/>";
echo "下载地址: ".$fileUrl."<br/>";
if (strlen($config['apiServer']) > 0) {
    echo "OnlyOffice API地址: ".$config['apiServer']."/web-apps/apps/api/documents/api.js<br/>";
}else{
    echo "OnlyOffice API地址: 未填写，请在插件中心配置有效地址<br/>";
}
echo "OnlyOffice CallbackURL: ".$cbUrl."<br/>";
?>