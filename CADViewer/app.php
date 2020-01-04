<?php

class CADViewerPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regiest() {
        $this->hookRegiest(array(
            'user.commonJs.insert' => 'CADViewerPlugin.echoJs'
        ));
    }
    public function echoJs($st,$act) {
        if ($this->isFileExtence($st,$act)) {
            $this->echoFile('static/main.js');
        }
    }
    public function index() {
		if(substr($this->in['path'],0,4) == 'http'){
			$path = $fileUrl = $this->in['path'];
		}else{
			$path = _DIR($this->in['path']);
			$fileUrl  = _make_file_proxy($path);
			if (!file_exists($path)) {
				show_tips(LNG('not_exists'));
			}
        }
        $fileName = get_path_this(rawurldecode($this->in['path']));

        $api = "https://sharecad.org/cadframe/load?url=";
        $data = $api.urlencode($fileUrl);
        header('Location: '.$api.urlencode($fileUrl));
        //include($this->pluginHost.'static/template.php');
    }
}