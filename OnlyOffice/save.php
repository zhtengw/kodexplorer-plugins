<?php
    if (($body_stream = file_get_contents("php://input"))===FALSE){
        echo "Bad Request";
    }
    $data = json_decode($body_stream, TRUE);
    if ($data["status"] == 2){
        if (($new_office_content = file_get_contents($data["url"]))===FALSE){
            echo "Bad Response";
        } else {
            file_put_contents($_GET['path'], $new_office_content, LOCK_EX);
        }
    }
    echo "{\"error\":0}";
?>