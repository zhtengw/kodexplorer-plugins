<?php
    
    $response = ['error' => 0];
    
    if (($body_stream = file_get_contents("php://input"))===FALSE){
        $response['error'] = "Bad Request";
    }
    $data = json_decode($body_stream, TRUE);
    if ($data["status"] == 2){
        if (($new_office_content = file_get_contents($data["url"]))===FALSE){
            $response['error'] = "Bad Response";
        } else {
            if (isset($_GET['hist'])) {
                $histDir = $_GET['hist'];
                $histInfo = $histDir.'/history.json';
                
                // 读取旧历史信息并设定文档版本
                if(file_exists($histInfo) && $prehist = file_get_contents($histInfo)) {
                    $history = json_decode($prehist,TRUE);
                    $version = end($history)['version'] + 1;
                } else {
                    $history = [];
                    $version = 0 ;
                }
                
                // New history
                $key = $data['key'];
                $changesFile = $histDir.'/changes-'.$key.'.zip';
                $histDoc = $histDir.'/'.$key.'.'.pathinfo($data["url"], PATHINFO_EXTENSION);
                $serverVersion = $data['history']['serverVersion'];
                
                $changes = $data['history']['changes'];
                if($changesData = file_get_contents($data['changesurl'])) {
                    file_put_contents($changesFile,$changesData, LOCK_EX);
                }
                
                array_push($history,
                    array(
                        "changes" => $changes,
                        "created" => $changes[0]['created'],
                        "key"     => $key,
                        "serverVersion" => $serverVersion,
                        "user"    => $changes[0]['user'],
                        "version" => $version,
                        )
                    );
                file_put_contents($histInfo,json_encode($history),LOCK_EX);
            }
            file_put_contents($_GET['path'], $new_office_content, LOCK_EX);
        }
    }
    
    die(json_encode($response));
?>