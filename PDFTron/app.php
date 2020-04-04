<?php

class pdftronPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regist() {
        $this->hookRegist(array(
            'user.commonJs.insert' => 'pdftronPlugin.echoJs'
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

        $lang = strtolower(str_replace('-','_',substr(I18n::getType(),0)));
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