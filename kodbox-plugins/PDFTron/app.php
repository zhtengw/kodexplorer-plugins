<?php

class PDFTronPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regist() {
        $this->hookRegist(array(
            'user.commonJs.insert' => 'PDFTronPlugin.echoJs'
        ));
    }
    public function echoJs() {
        $this->echoFile('static/main.js');

    }
    public function index() {
        $path = $this->filePath($this->in['path']);
        $fileUrl = $this->filePathLinkOut($this->in['path']);
        //$localFile = $this->pluginLocalFile($this->in['path']);

        $fileName = $this->fileInfo['name'];
        $config = $this->getConfig();

        //界面语言
        $lang = strtolower(str_replace('-','_',substr(I18n::getType(),0)));
        
        // 设定未登录用户的文档信息
        if (Session::get('kodUser') == null) {
            $user = 'guest';
        } else {
            $user = Session::get('kodUser.name');
        }
        
        //kodbox默认最低权限是canView可预览，所以文档默认权限是ViewOnly
        $isViewOnly = true;
        $canWrite = false;
        //可读权限检测，可读则可下载及打印
        if (Action("explorer.auth")->fileCanRead($path)) {
            $isViewOnly = false;
        }

        //可写权限检测
        if (Action("explorer.auth")->fileCanWrite($path)) {
            $isViewOnly = false;
            $canWrite = true;
        }
        
        include($this->pluginPath.'/static/template.php');
        
    }
    public function save() {
        $pdf_stream = file_get_contents("php://input");

        if ($pdf_stream) {
        //file_put_contents($_GET['path'], $pdf_stream, LOCK_EX);
	    $this->pluginCacheFileSet($_GET['path'], $pdf_stream);
        echo "{\"error\":0}";
        exit;
        }
    }
}