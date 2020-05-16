<?php
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
//header('Access-Control-Max-Age: 1000');
//header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$action = $_GET['act'];
if ($action == 'save') {
    saveBack();
}
if ($action == 'sent') {
    filePost();
}

function filePost() {
    $data = base64_decode($_GET['data']);
    echo $data;
}

function saveBack() {
    if (($body_stream = file_get_contents("php://input"))===FALSE){
        echo "Bad Request";
    }
    $data = json_decode($body_stream, TRUE);
    if (!$data['data']["unchanged"]){
        if (($new_office_content = file_get_contents($_GET['api'].$data['data']["docURL"]))===FALSE){
            echo "Bad Response";
        } else {
            file_put_contents($_GET['path'], $new_office_content, LOCK_EX);
        }
    }
    echo "{\"error\":0}";
}