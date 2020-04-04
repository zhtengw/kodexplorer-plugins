<?php

class pdftronPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regiest() {
        $this->hookRegiest(array(
            'user.commonJs.insert' => 'pdftronPlugin.echoJs'
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

        $lang = strtolower(str_replace('-','_',substr(I18n::getType(),0)));
        $config = $this->getConfig();
        include($this->pluginPath.'/static/template.php');

    }
}