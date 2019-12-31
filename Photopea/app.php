<?php

class PhotopeaPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regist() {
        $this->hookRegist(array(
            'user.commonJs.insert' => 'PhotopeaPlugin.echoJs'
        ));
    }
    public function echoJs(){
        $this->echoFile('static/main.js');
    }
    public function index() {
		$path = $this->filePath($this->in['path']);
		$localFile = $this->pluginLocalFile($path);
		$fileUrl = $this->filePathLink($this->in['path']).'&name=/'.$this->in['name'];
		$fileUrl2 = $this->filePathLinkOut($this->in['path']);
        $fileName = $this->fileInfo['name'];
        $fileExt = get_path_ext($this->fileInfo['name']);
        

//        $fileUrl = $this->pluginHost.'php/handler.php?act=sent&path='.$path;
        $saveUrl = $this->pluginHost.'php/handler.php?act=save&path='.rawurlencode($localFile);
        $fullUri = '{"files":["'.$fileUrl.'"],"resources":[],"server":{"version":1,"url":"'.$saveUrl.'","formats":["'.$fileExt.'"]},"environment":{},"script":""}';

		$config = $this->getConfig();

        //show_tips($fileUrl2);
        header('Location:'.$this->pluginHost.'/static/photopea/#'.($fullUri));
        //$this->pluginCacheFileSet($path, file_get_contents($localFile));
        del_file($localFile);
    }
}