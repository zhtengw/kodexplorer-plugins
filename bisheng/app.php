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
        $fileName = get_path_this($path);
        $fileExt = get_path_ext($path);
        
        $config = $this->getConfig();
        $apiServer = $config['apiServer'].'/apps/editor/openPreview?data=';
        $options = array(
            'doc' => array(
                'docId' => md5_file($path),
                'title' => $fileName,
                //'mime_type' => mime_content_type($fileName),
                'fetchUrl' => $fileUrl,
                'callback' => '',),
            'user' => array(
                'uid' => $_SESSION['kodUser']['userID'],
                'nickName' => $_SESSION['kodUser']['nickName'].' ('.$_SESSION['kodUser']['name'].')',
                'avatar' => '',
                'privilege' => array('FILE_READ','FILE_DOWNLOAD', 'FILE_PRINT',),
                )
            );
        $timestamp = filemtime($path);
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
        if (check_file_writable_user($path)) {
            array_push($options['user']['privilege'],'FILE_WRITE');
            $options['doc']['docId'] = md5($path.$timestamp);
            $options['doc']['callback'] = $this->pluginHost.'php/save.php?path='.$path.'&api='.$config['apiServer'];
            $apiServer = $config['apiServer'].'/apps/editor/openEditor?data=';
        }

        if (strlen($apiServer) > 0) {
            //print_r(json_encode($options));
            header('Location:'.$apiServer.base64_encode(json_encode($options)));
        } else {
            show_tips("bisheng Document Server is not available.");
        }
    }
}
