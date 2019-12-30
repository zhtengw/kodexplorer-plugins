<?php

class OnlyOfficePlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regist() {
        $this->hookRegist(array(
            'user.commonJs.insert' => 'OnlyOfficePlugin.echoJs'
        ));
    }
    public function echoJs() {
        $this->echoFile('static/main.js');
    
    }
    public function index() {
        if (substr($this->in['path'],0,4) == 'http') {
            $path = $fileUrl = $this->in['path'];
        } else {
            $path = _DIR($this->in['path']);
            $fileUrl = _make_file_proxy($path);
            if (!file_exists($path)) {
                show_tips(LNG('not_exists'));
            }
        }
        $fileName = get_path_this($path);
        $fileExt = get_path_ext($path);
        $cbUrl = $this->pluginHost.'php/save.php?path='.rawurlencode($path);
        
        $config = $this->getConfig();
        if(substr(APP_HOST,0,8) == 'https://'){
            $dsServer = $config['apiServer-https'];
            $http_header = 'https://';
        }else{
            $dsServer = $config['apiServer-http'];
            $http_header = 'http://';
        }
        $apiServer = $http_header.$dsServer;
        if (strlen($dsServer) > 0) {
            include($this->pluginPath.'/php/office.php');
        } else {
            include($this->pluginPath.'/php/test.php');
        }
    }
    function getDocumentType($ext){
        $ExtsDoc = array("doc", "docm", "docx", "dot", "dotm", "dotx", "epub", "fodt", "htm", "html", "mht", "odt", "pdf", "rtf", "txt", "djvu", "xps");
        $ExtsPre = array("fodp", "odp", "pot", "potm", "potx", "pps", "ppsm", "ppsx", "ppt", "pptm", "pptx");
        $ExtsSheet = array("csv", "fods", "ods", "xls", "xlsm", "xlsx", "xlt", "xltm", "xltx");
        if (in_array($ext,$ExtsDoc)) {
            return "text";
        } elseif (in_array($ext,$ExtsPre)){
            return "presentation";
        } elseif (in_array($ext,$ExtsSheet)){
            return "spreadsheet";
        } else {
            return "unknown";
        }
    }
}