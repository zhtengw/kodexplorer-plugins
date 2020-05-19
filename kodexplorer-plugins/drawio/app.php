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

        $newfile = false;

        $config = $this->getConfig();

        // 解析出文件里的diagram内容
        $content = file_get_contents($fileUrl);
        $xml = simplexml_load_string($content);
        $diagram = json_decode(json_encode($xml),true)['diagram']['0'];

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
        if (check_file_writable_user($path)) {
            if (empty($diagram)) {
                $newfile = true;
            }
            // 有写入权限的登录用户，显示嵌入编辑界面
            $url_params = '?embed=1&ui='.$theme.'&lang='.$lang.'&spin=1&proto=json'.'&editable=false';
        } else {
            // 无写入权限或者未登录用户，显示分享预览界面
            $url_params = '?embed=1&ui='.$theme.'&lang='.$lang.'&proto=json'.'&lightbox=1&highlight=0000ff&layers=1&nav=1&chrome=0';
        }
        
        $serverAddr .= $url_params;
        include($this->pluginPath.'/static/template.php');

    }


}