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
        
        //show_tips($path);
        $config = $this->getConfig();
        $apiServer = $config['apiServer'].'/apps/editor/openPreview?callURL=';
        $options = array(
            'doc' => array(
                'docId' => md5_file($localFile),
                'title' => $fileName,
                //'mime_type' => mime_content_type($fileName),
                'fetchUrl' => $fileUrl,
                'callback' => '',
                //'opts' => array('pdf_viewer' => ($this->in['viewtype'] == 'pdf')),
                'pdf_viewer' => ($this->in['viewtype'] == 'pdf'),
                ),
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
            $options['doc']['callback'] = $this->pluginApi.'save&path='.rawurlencode($path).'&api='.$config['apiServer'];
            //if(!$options['doc']['opts']['pdf_viewer'])
            if(!$options['doc']['pdf_viewer']) $apiServer = $config['apiServer'].'/apps/editor/openEditor?callURL=';
        }

        $apiKey = $config['apiKey'];
        $data = base64_encode(json_encode($options));

        $postUrl = $this->pluginApi.'filePost&data='.$data;
        $callURL = base64_encode($postUrl);
        if (strlen($apiServer) > 0) {
            //show_tips(json_encode($options));
            if (strlen($apiKey) > 0) {
                $sign = hash_hmac('md5',$callURL,$apiKey);
                //show_tips($callURL.'<br/>'.$sign);
                header('Location:'.$apiServer.$callURL.'&sign='.$sign);
            } else {
                header('Location:'.$apiServer.$callURL);
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
                $this->pluginCacheFileSet($_GET['path'], $new_office_content);
            }
        }
        echo "{\"error\":0}";
    }
    public function filePost() {
        $data = base64_decode($_GET['data']);
        echo $data;
    }
}
