<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-type: application/json; charset="utf-8"');

$fi = fopen("php://input", "rb");
$p = JSON_decode(fread($fi, 2000));
$fo = fopen($_GET['path'],"wb");
while ($buf = fread($fi,50000)) {
    fwrite($fo,$buf);
}
fclose($fi);
fclose($fo);
echo '{"message": "Saved!"}';
