<?php

class PDFTronPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regiest() {
        $this->hookRegiest(array(
            'user.commonJs.insert' => 'PDFTronPlugin.echoJs'
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
                show_tips(LNG('not_exists'.$path));
            }
        }
        $fileName = get_path_this(rawurldecode($this->in['path']));

        //界面语言
        $lang = strtolower(str_replace('-','_',substr(I18n::getType(),0)));
        $config = $this->getConfig();
        
        // 设定未登录用户的文档信息
        if (!isset($_SESSION['kodUser'])) {
            $user = 'guest';
            $isViewOnly = true;
            $canWrite = false;
        } else {
            $user = $_SESSION['kodUser']['name'];
            //KodExplorer默认权限是canRead
            $isViewOnly = false;
            $canWrite = false;
        }
        
        if (!$GLOBALS['isRoot']) {
            /** * 下载&打印&导出:权限取决于文件是否可以下载;(管理员无视所有权限拦截) * 1. 当前用户是否允许下载 * 2. 所在群组文件，用户在群组内的权限是否可下载 * 3. 文件分享,限制了下载 */
            if ($GLOBALS['auth'] && !$GLOBALS['auth']['explorer.fileDownload']) {
                $isViewOnly = true;
            }
            if ($GLOBALS['kodShareInfo'] && $GLOBALS['kodShareInfo']['notDownload'] == '1') {
                $isViewOnly = true;
            }
            if ($GLOBALS['kodPathRoleGroupAuth'] && !$GLOBALS['kodPathRoleGroupAuth']['explorer.fileDownload']) {
                $isViewOnly = true;
            }
        }
        //可写权限检测
        if (check_file_writable_user($path)) {
            $canWrite = true;
        }
        
        include($this->pluginPath.'/static/template.php');

    }
}