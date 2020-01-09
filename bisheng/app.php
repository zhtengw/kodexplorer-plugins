<?php

class bishengPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regist() {
        $this->hookRegist(array(
            'user.commonJs.insert' => 'bishengPlugin.echoJs'
        ));
    }
    public function echoJs() {
        $this->echoFile('static/main.js');

    }
    public function index() {
        $path = $this->filePath($this->in['path']);
        $localFile = $this->pluginLocalFile($this->in['path']);
        $fileUrl = $this->filePathLinkOut($this->in['path']);
        $fileName = $this->fileInfo['name'];
        $fileExt = get_path_ext($this->fileInfo['name']);

        $config = $this->getConfig();
        $apiServer = $config['apiServer'].'/apps/editor/openPreview?data=';
        $options = array(
            'doc' => array(
                'docId' => md5_file($localFile),
                'title' => $fileName,
                //'mime_type' => mime_content_type($fileName),
                'fetchUrl' => $fileUrl,
                'callback' => '',),
            'user' => array(
                'uid' => Session::get('kodUser.userID'),
                'nickName' => Session::get('kodUser.nickName').' ('.Session::get('kodUser.name').')',
                'avatar' => Session::get('kodUser.avatar'),
                'privilege' => array('FILE_READ'),
                )
            );
        $timestamp = filemtime($localFile);

        //kodbox默认最低权限是canView可预览
        //可读权限检测，可读则可下载及打印
        if (Action("explorer.auth")->fileCanRead($path)) {
            array_push($options['user']['privilege'],'FILE_DOWNLOAD', 'FILE_PRINT');
        }

        //可写权限检测
        if (Action("explorer.auth")->fileCanWrite($path)) {
            array_push($options['user']['privilege'],'FILE_WRITE');
            $options['doc']['docId'] = md5($localFile.$timestamp);
            $options['doc']['callback'] = $this->pluginApi.'save&cache='.$localFile.'&path='.$path.'&api='.$config['apiServer'];
            $apiServer = $config['apiServer'].'/apps/editor/openEditor?data=';
        }
        
        $apiKey = $config['apiKey'];
        $data = base64_encode(json_encode($options));
        if (strlen($apiServer) > 0) {
            //print_r(json_encode($options));
            if (strlen($apiKey) > 0) {
                $sign = hash_hmac('md5',$data,$apiKey);
                header('Location:'.$apiServer.$data.'&sign='.$sign);
            } else {
                header('Location:'.$apiServer.$data);
            }
        } else {
            show_tips("bisheng Document Server is not available.");
        }
    }
    public function save() {
        if (($body_stream = file_get_contents("php://input")) === FALSE) {
            echo "Bad Request";
        }
        $data = json_decode($body_stream, TRUE);
        if (!$data['data']["unchanged"]) {
            if (($new_office_content = file_get_contents($_GET['api'].$data['data']["docURL"])) === FALSE) {
                echo "Bad Response";
            } else {
                if(file_put_contents($_GET['cache'], $new_office_content, LOCK_EX)){
                    $this->pluginCacheFileSet($_GET['path'], file_get_contents($_GET['cache']));
                    del_file($_GET['cache']);
                }

            }
        }
        echo "{\"error\":0}";
    }
}
