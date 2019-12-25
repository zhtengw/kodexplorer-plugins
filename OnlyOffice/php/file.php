<?php
$file = $_GET['path'];
if (!file_exists($file)) {
    Header('HTTP/1.1 404 NOT FOUND');
    echo "File ".$file." NOT Found";
} else {
    //以只读和二进制模式打开文件
    $steam = fopen ($file, "rb");
    //告诉浏览器这是一个文件流格式的文件
    Header("Content-type: application/octet-stream");
    //请求范围的度量单位
    Header("Accept-Ranges: bytes");
    //Content-Length是指定包含于请求或响应中数据的字节长度
    Header("Accept-Length: ".filesize($file));
    //用来告诉浏览器，文件是可以当做附件被下载，下载后的文件名称为$file_name该变量的值。
    Header("Content-Disposition: attachment; filename=".pathinfo($file,PATHINFO_BASENAME));
    // 指定允许其他域名访问  
    Header('Access-Control-Allow-Origin: *');  
    // 响应类型  
    Header('Access-Control-Allow-Methods: *');  
    // 响应头设置  
    Header('Access-Control-Allow-Headers: x-requested-with,content-type');
    //读取文件内容并直接输出到浏览器
    echo fread($steam, filesize($file));
    fclose($steam);
    exit();
}