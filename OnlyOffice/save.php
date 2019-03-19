<?php
    if (($body_stream = file_get_contents("php://input"))===FALSE){
        echo "Bad Request";
    }
    $data = json_decode($body_stream, TRUE);
    if ($data["status"] == 2){
        $downloadUri = $data["url"];
        if (($new_data = file_get_contents($downloadUri))===FALSE){
            echo "Bad Response";
        } else {
            file_put_contents($_GET['path'], $new_data, LOCK_EX);
        }
    }
    echo "{\"error\":0}";
?>