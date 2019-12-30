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
        if (substr($this->in['path'],0,4) == 'http') {
            $path = $this->in['path'];
        } else {
            $path = _DIR($this->in['path']);
            if (!file_exists($path)) {
                show_tips(LNG('not_exists'));
            }
        }
        $fileName = get_path_this($path);
        $fileExt = get_path_ext($path);
        $fileUrl = $this->pluginHost.'php/handler.php?act=sent&path='.rawurlencode($path);
        $saveUrl = $this->pluginHost.'php/handler.php?act=save&path='.rawurlencode($path);
        $fullUri = '{"files":["'.$fileUrl.'"],"server":{"version":1,"url":"'.$saveUrl.'","formats":["'.$fileExt.'"]}}';

        header('Location:https://www.photopea.com/#'.$fullUri);
    }
}