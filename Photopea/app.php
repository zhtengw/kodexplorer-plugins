<?php

class PhotopeaPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regiest() {
        $this->hookRegiest(array(
            'user.commonJs.insert' => 'PhotopeaPlugin.echoJs'
        ));
    }
    public function echoJs($st,$act) {
        if ($this->isFileExtence($st,$act)) {
            $this->echoFile('static/main.js');
        }
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
        $fileUrl = $this->pluginHost.'php/fileproc.php?act=sent&path='.$path;
        $saveUrl = $this->pluginHost.'php/fileproc.php?act=save&path='.$path;
        $fullUri = '{"files":["'.$fileUrl.'"],"server":{"version":1,"url":"'.$saveUrl.'","formats":["'.$fileExt.'"]}}';

        header('Location:https://www.photopea.com/#'.$fullUri);
    }
}