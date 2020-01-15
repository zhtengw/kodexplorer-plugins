<?php

class drawioPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regist() {
        $this->hookRegist(array(
            'user.commonJs.insert' => 'drawioPlugin.echoJs'
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

        $newfile = false;

        $config = $this->getConfig();

        if (!empty($this->in['share'])) {
            // Share Diagram
            include($this->pluginPath.'/static/share.php');
        } else {
            // open editor
            $serverAddr = $config['serverAddr'];

            $theme = $config['theme'];
            $lang = substr(I18n::getType(),0,2);
            $url_params = '?embed=1&ui='.$theme.'&lang='.$lang.'&spin=1&proto=json';

            $content = file_get_contents($fileUrl);

            // 去除文件中的空格
            $content_rep = str_replace(" ", '', $content);

            if (empty($serverAddr)) {
                if (file_exists($this->pluginPath.'static/draw/index.html')) {
                    $serverAddr = $this->pluginHost.'static/draw';
                } else {
                    $serverAddr = 'https://www.draw.io';
                }
            }
            $serverAddr .= $url_params;

            if (!empty($this->in['newfile']) || empty($content_rep) ) {
                $newfile = true;
            }
            include($this->pluginPath.'/static/template.php');
        }
    }
}