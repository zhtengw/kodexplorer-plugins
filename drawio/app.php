<?php

class drawioPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regiest() {
        $this->hookRegiest(array(
            'user.commonJs.insert' => 'drawioPlugin.echoJs'
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
				show_tips(LNG('not_exists'.$path));
			}
        }
        $fileName = get_path_this(rawurldecode($this->in['path']));

        $newfile = false;

		$config = $this->getConfig();
        
        $serverAddr = $config['serverAddr'];
        
        $theme = $config['theme'];
        $lang = substr(I18n::getType(),0,2);
        $url_params = '?embed=1&ui='.$theme.'&lang='.$lang.'&spin=1&proto=json';
        
        $content = file_get_contents($fileUrl);
        
        if (empty($serverAddr)) {
            if (file_exists($this->pluginPath.'static/draw/index.html')){
                $serverAddr = $this->pluginHost.'static/draw';
            }else{
                $serverAddr = 'https://www.draw.io';
            }
        }
        $serverAddr .= $url_params;
        
        if(!empty($this->in['newfile']) || empty($content)){
            $newfile = true;
        }
        include($this->pluginPath.'/static/template.php');
        
    }
}