<?php
    if (($body_stream = file_get_contents("php://input"))===FALSE){
        echo "Bad Request";
    }
    $data = json_decode($body_stream, TRUE);
    //file_put_contents('/mnt/dump/public/data.txt',$body_stream);
    //file_put_contents('/mnt/dump/public/docURL.txt',$_GET['api'].$data['data']["docURL"]);
    if (!$data['data']["unchanged"]){
        if (($new_office_content = file_get_contents($_GET['api'].$data['data']["docURL"]))===FALSE){
            echo "Bad Response";
        } else {
            file_put_contents($_GET['path'], $new_office_content, LOCK_EX);
        }
    }
    echo "{\"error\":0}";
?>