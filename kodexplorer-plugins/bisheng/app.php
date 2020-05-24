<?php

class bishengPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regiest() {
        $this->hookRegiest(array(
            'user.commonJs.insert' => 'bishengPlugin.echoJs'
        ));
    }
    public function echoJs($st,$act) {
        if ($this->isFileExtence($st,$act)) {
            $this->echoFile('static/main.js');
        }
    }
    public function index() {
        if (substr($this->in['path'],0,4) == 'http') {
            $path = $fileUrl = $this->in['path'];
        } else {
            $path = _DIR($this->in['path']);
            $fileUrl = _make_file_proxy($path);
            if (!file_exists($path)) {
                show_tips(LNG('not_exists'));
            }
        }
        $fileName = get_path_this(rawurldecode($this->in['path']));
        $fileExt = get_path_ext($path);
        
        $config = $this->getConfig();
        $apiServer = $config['apiServer'].'/apps/editor/openPreview?callURL=';
        //show_tips(json_encode($_SESSION));
        $options = array(
            'doc' => array(
                'docId' => file_hash_simple($path),
                'title' => $fileName,
                //'mime_type' => mime_content_type($fileName),
                'fetchUrl' => $fileUrl,
                'callback' => '',
                'pdf_viewer' => ($this->in['viewtype'] == 'pdf'),
                ),
            'user' => array(
                'uid' => $_SESSION['kodUser']['userID'],
                'nickName' => $_SESSION['kodUser']['nickName'].' ('.$_SESSION['kodUser']['name'].')',
                'avatar' => '',
                'privilege' => array('FILE_READ','FILE_DOWNLOAD', 'FILE_PRINT',),
                )
            );
        
        // 设定未登录用户的文档信息
        if (!isset($_SESSION['kodUser'])) {
            $options['user']['uid'] = 'guest';
            $options['user']['nickName'] = 'guest';
            $options['user']['privilege'] = array('FILE_READ',);
        }
        
        if (!$GLOBALS['isRoot']) {
            /** * 下载&打印&导出:权限取决于文件是否可以下载;(管理员无视所有权限拦截) * 1. 当前用户是否允许下载 * 2. 所在群组文件，用户在群组内的权限是否可下载 * 3. 文件分享,限制了下载 */
            if ($GLOBALS['auth'] && !$GLOBALS['auth']['explorer.fileDownload']) {
                $options['user']['privilege'] = array('FILE_READ',);
            }
            if ($GLOBALS['kodShareInfo'] && $GLOBALS['kodShareInfo']['notDownload'] == '1') {
                $options['user']['privilege'] = array('FILE_READ',);
            }
            if ($GLOBALS['kodPathRoleGroupAuth'] && !$GLOBALS['kodPathRoleGroupAuth']['explorer.fileDownload']) {
                $options['user']['privilege'] = array('FILE_READ',);
            }
        }
        //可写权限检测
        if (!$config['previewMode'] && check_file_writable_user($path)) {
            array_push($options['user']['privilege'],'FILE_WRITE');
            $options['doc']['callback'] = $this->pluginHost.'php/handler.php?act=save&path='.rawurlencode($path).'&api='.$config['apiServer'];
            if(!$options['doc']['pdf_viewer']) $apiServer = $config['apiServer'].'/apps/editor/openEditor?callURL=';
        }
        
        $apiKey = $config['apiKey'];
        $data = base64_encode(json_encode($options));
        //show_tips($data);
        $postUrl = $this->pluginHost.'php/handler.php?act=sent&data='.$data;
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
}
