<?php

class CADViewerPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regist() {
        $this->hookRegist(array(
            'user.commonJs.insert' => 'CADViewerPlugin.echoJs'
        ));
    }
    public function echoJs() {
        $this->echoFile('static/main.js');
    
    }
    public function index() {
		$path = $this->filePath($this->in['path']);
		$fileUrl = $this->filePathLinkOut($this->in['path']);

        $api = "https://sharecad.org/cadframe/load?url=";
        $data = $api.urlencode($fileUrl);
        
        header('Location: '.$api.urlencode($fileUrl));
        //include($this->pluginHost.'static/template.php');
    }
}