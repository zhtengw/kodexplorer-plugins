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

        // 解析出文件里的diagram内容
        $content = file_get_contents($fileUrl);
        $xml = simplexml_load_string($content);
        $diagram = json_decode(json_encode($xml),true)['diagram'];
        if (empty($diagram)) {
            $newfile = true;
        }

        // 获取服务器地址
        $serverAddr = $config['serverAddr'];
        if (empty($serverAddr)) {
            if (file_exists($this->pluginPath.'static/draw/index.html')) {
                $serverAddr = $this->pluginHost.'static/draw';
            } else {
                $serverAddr = 'https://www.draw.io';
            }
        }

        $theme = $config['theme'];
        $lang = substr(I18n::getType(),0,2);
        //可写权限检测
        if (Action("explorer.auth")->fileCanWrite($path)) {
            // 有写入权限的登录用户，显示嵌入编辑界面
            $url_params = '?embed=1&ui='.$theme.'&lang='.$lang.'&spin=1&proto=json'.'&editable=false';
            $serverAddr .= $url_params;
            include($this->pluginPath.'/static/template.php');
        } else {
            // 无写入权限或者未登录用户，显示分享预览界面
            $url_params = '?ui='.$theme.'&lang='.$lang.'&lightbox=1&highlight=0000ff&layers=1&nav=1#R';
            $serverAddr .= $url_params;
            header('Location:'.$serverAddr.($diagram));
        }
        
    }
}