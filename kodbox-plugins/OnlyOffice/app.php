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
        $path = $this->filePath($this->in['path']);
        $fileUrl = $this->filePathLinkOut($this->in['path']);
        $fileName = $this->fileInfo['name'];
        $fileExt = get_path_ext($this->fileInfo['name']);
        $mtime = IO::infoFull($path)['modifyTime'];

        // kodbox中，同一文件在内部分享链接中打开时，path是不同的，但sourceID不变
        // 而本地路径的文件没有sourceID
        $sourceID = IO::infoFull($path)['sourceID']? : $path;
        //show_tips($sourceID);
        $config = $this->getConfig();
        if (!empty($this->in['clearhist'])) {
            if (Action("explorer.auth")->fileCanWrite($path)) {
                // 清空文档历史记录
                $histDir = $this->getHistDir($sourceID,false);
                $msg_title = "清空文档历史";
                if (file_exists($histDir)) {
                    // 页面上确认清理后调用clearHistDir函数，否则显示取消信息。
                    echo "<script>if (confirm('是否清理“".$fileName."”的文档历史？')){";
                    echo "location.href='".$this->pluginApi."clearHistDir&histDir=".$histDir."';}</script>";
                    $msg_content = "用户取消。";
                    include($this->pluginPath.'/php/show_msg.php');
                    return;
                } else {
                    $msg_content = '“'.$fileName.'”没有文档历史记录，无需清理。';
                    include($this->pluginPath.'/php/show_msg.php');
                    return;
                }
            } else {
                show_tips("没有权限。");
            }
        }

        if (substr(APP_HOST,0,8) == 'https://') {
            $dsServer = $config['apiServer-https'];
            $http_header = 'https://';
        } else {
            $dsServer = $config['apiServer-http'];
            $http_header = 'http://';
        }

        $apiServer = $http_header.$dsServer;
        $options = [
            'document' => [
                'fileType' => $this->fileTypeAlias($fileExt),
                'key' => IO::hashSimple($path).$mtime,
                'title' => $fileName,
                'url' => $fileUrl,
                'permissions' => [
                    'download' => true,
                    'edit' => false,
                    'print' => true,
                ],
            ],
            'documentType' => $this->getDocumentType($fileExt),
            'type' => 'desktop',
            'editorConfig' => [
                'callbackUrl' => "",
                'lang' => I18n::getType(),
                'mode' => 'view',
                'user' => [
                    'id' => Session::get('kodUser.userID'),
                    'name' => Session::get('kodUser.nickName').' ('.Session::get('kodUser.name').')',
                ],
                'customization' => [
                    'autosave' => true,
                    'chat' => strpos($config['editorOpt'],'chat') !== false? true: false,
                    'commentAuthorOnly' => true,
                    'comments' => strpos($config['editorOpt'],'comments') !== false? true: false,
                    'compactHeader' => false,
                    'compactToolbar' => false,
                    'help' => strpos($config['editorOpt'],'help') !== false? true: false,
                    'toolbarNoTabs' => false,
                    'hideRightMenu' => false,
                ],
            ],
            'height' => "100%",
            'width' => "100%"
        ];

        // 设定未登录用户的文档信息
        if (Session::get('kodUser') == null) {
            $options['editorConfig']['user']['id'] = 'guest';
            $options['editorConfig']['user']['name'] = 'guest';
            $options['document']['permissions']['download'] = false;
            $options['document']['permissions']['print'] = false;
        }

        //可读权限检测，可读则可下载及打印
        if (Action("explorer.auth")->fileCanRead($path)) {
            $options['document']['permissions']['download'] = true;
            $options['document']['permissions']['print'] = true;
        }

        //可写权限检测
        if (!$config['previewMode'] && Action("explorer.auth")->fileCanWrite($path)) {
            $options['editorConfig']['mode'] = 'edit';
            $options['document']['permissions']['edit'] = true;
            $options['editorConfig']['callbackUrl'] = $this->pluginApi.'save&path='.rawurlencode($path);

            //如果开启了文档历史记录，且为文字文档
            if ($config['history'] && $this->supportHistory($fileExt)) {
                $curkey = $options['document']['key'];
                $curDocUrl = $options['document']['url'];
                $histDir = $this->getHistDir($sourceID,true);

                $options['editorConfig']['callbackUrl'] .= '&hist='.$histDir;
                $curDoc = file_get_contents($options['document']['url']);
                file_put_contents($histDir.'/'.$curkey.'.'.$fileExt,$curDoc,LOCK_EX);

                $curInfo = [
                    'created' => date('Y-m-d H:i:s', $mtime),
                    'key' => $curkey,
                    'user' => [
                        'id' => $options['editorConfig']['user']['id'],
                        'name' => $options['editorConfig']['user']['name'],
                    ],
                ];
                $allHist = $this->getHistory($histDir,$curInfo,$curDocUrl,$fileExt);
                //show_tips($allHist);
            }
        }
        //内部对话框打开时，使用紧凑显示
        if ($config['openWith'] == 'dialog') {
            $options['editorConfig']['customization']['compactHeader'] = true;
            $options['editorConfig']['customization']['hideRightMenu'] = true;
            $options['document']['title'] = " ";
        }
        //匹配移动端
        if (is_wap()) {
            $options['type'] = 'mobile';
        }

        if (strlen($dsServer) > 0) {
            include($this->pluginPath.'/php/office.php');
        } else {
            $error_msg = "OnlyOffice Document Server is not available.<br/>".
            "The API of \"".$http_header."\" must be filled.";
            show_tips($error_msg);
        }
    }
    public function getHistDir($path,$gen = false) {
        //在temp目录生成文档历史文件夹，用路径的md5命名
        $pathID = md5($path);
        $prefix = 'OnlyOffice/';
        $histDir = TEMP_PATH.$prefix.$pathID;
        if ($gen) {
            if (!file_exists($histDir) && !is_dir($histDir)) {
                mk_dir($histDir);
            }
        }
        return $histDir;
    }

    public function getHistory($histDir,$curInfo, $curUrl,$ext) {
        // 文档历史由三个文件提供信息
        // history.json 保存基本信息
        // docid.扩展名
        // changes-docid.zip
        // 参考资料：
        // https://api.onlyoffice.com/editors/callback
        // https://api.onlyoffice.com/editors/history
        // https://blog.51cto.com/8200238/2085279
        // https://github.com/ONLYOFFICE/document-server-integration/blob/master/web/documentserver-example/php/webeditor-ajax.php

        $histInfo = $histDir.'/history.json';
        $curkey = $curInfo['key'];
        if (file_exists($histInfo) && $history = json_decode(file_get_contents($histInfo),TRUE)) {
            $curVer = end($history)['version']+1;

        } else {
            $curVer = 0;
            $history = [];
        }
        $histData = [];
        for ($i = 0; $i <= $curVer; $i++) {
            $histObj = [];
            $dataObj = [];

            $key = $i == $curVer ? $curkey : $history[$i]['key'];
            $histObj["key"] = $key;
            $histObj["version"] = $i;

            $dataObj["key"] = $key;
            $dataObj["version"] = $i;
            $changesFile = $histDir.'/changes-'.$key.'.zip';
            $histDoc = $histDir.'/'.$key.'.'.$ext;
            if ($i !== $curVer) {
                // changesUrl用handle.php处理以避免CORS
                $dataObj["changesUrl"] = $this->pluginHost.'php/handler.php?act=sent&path='.rawurlencode($changesFile);
            }
            $dataObj["url"] = $i == $curVer ? $curUrl : $this->pluginHost.'php/handler.php?act=sent&path='.rawurlencode($histDoc);

            if ($i > 0) {
                $prehist = $history[$i-1];
                $prekey = $prehist['key'];
                $preDoc = $histDir.'/'.$prekey.'.'.$ext;

                $dataObj['previous'] = [
                    "key" => $prekey,
                    "url" => $this->pluginHost.'php/handler.php?act=sent&path='.rawurlencode($preDoc),
                ];
            }

            $histData[$i] = $dataObj;
        }
        $curInfo['version'] = $curVer;
        array_push($history,$curInfo);

        $allhist = [];
        array_push($allhist, [
            "currentVersion" => $curVer,
            "history" => $history
        ],$histData);

        return $allhist;
    }

    public function clearHistDir() {
        del_dir($_GET['histDir']);
        $msg_title = "清空文档历史";
        $msg_content = "清理完成。";
        include($this->pluginPath.'/php/show_msg.php');
        return "clear history done";
    }

    private function supportHistory($ext) {
        // OnlyOffice文档历史仅支持可编辑的文字文档
        $supportExts = array("doc", "docx", "dotx", "html", "odt", "ott", "rtf", "txt");
        if (in_array($ext,$supportExts)) {
            return true;
        } else {
            return false;
        }
    }
    private function getDocumentType($ext) {
        $ExtsDoc = array("doc", "docm", "docx", "dot", "dotm", "dotx", "epub", "fodt", "ott", "htm", "html", "mht", "odt", "pdf", "rtf", "txt", "djvu", "xps");
        $ExtsPre = array("fodp", "odp", "pot", "potm", "potx", "pps", "ppsm", "ppsx", "ppt", "pptm", "pptx", "otp");
        $ExtsSheet = array("xls", "xlsx", "xltx", "ods", "ots", "csv", "xlt", "xltm", "fods");
        if (in_array($ext,$ExtsDoc)) {
            return "text";
        } elseif (in_array($ext,$ExtsPre)) {
            return "presentation";
        } elseif (in_array($ext,$ExtsSheet)) {
            return "spreadsheet";
        } else {
            return "unknown";
        }
    }
    private function fileTypeAlias($ext) {
        if (strpos(".docm.dotm.dot.wps.wpt",'.'.$ext) !== false) {
            $ext = 'doc';
        } else if (strpos(".xlt.xltx.xlsm.dotx.et.ett",'.'.$ext) !== false) {
            $ext = 'xls';
        } else if (strpos(".pot.potx.pptm.ppsm.potm.dps.dpt",'.'.$ext) !== false) {
            $ext = 'ppt';
        }
        return $ext;
    }
    public function save() {

        $response = ['error' => 0];

        if (($body_stream = file_get_contents("php://input")) === FALSE) {
            $response['error'] = "Bad Request";
        }
        $data = json_decode($body_stream, TRUE);
        if ($data["status"] == 2) {
            if (($new_office_content = file_get_contents($data["url"])) === FALSE) {
                $response['error'] = "Bad Response";
            } else {
                if (isset($_GET['hist'])) {
                    $histDir = $_GET['hist'];
                    $histInfo = $histDir.'/history.json';

                    // 读取旧历史信息并设定文档版本
                    if (file_exists($histInfo) && $prehist = file_get_contents($histInfo)) {
                        $history = json_decode($prehist,TRUE);
                        $version = end($history)['version'] + 1;
                    } else {
                        $history = [];
                        $version = 0 ;
                    }

                    // New history
                    $key = $data['key'];
                    $changesFile = $histDir.'/changes-'.$key.'.zip';
                    $histDoc = $histDir.'/'.$key.'.'.pathinfo($data["url"], PATHINFO_EXTENSION);
                    $serverVersion = $data['history']['serverVersion'];

                    $changes = $data['history']['changes'];
                    if ($changesData = file_get_contents($data['changesurl'])) {
                        file_put_contents($changesFile,$changesData, LOCK_EX);
                    }

                    array_push($history,
                        array(
                            "changes" => $changes,
                            "created" => $changes[0]['created'],
                            "key" => $key,
                            "serverVersion" => $serverVersion,
                            "user" => $changes[0]['user'],
                            "version" => $version,
                        )
                    );
                    file_put_contents($histInfo,json_encode($history),LOCK_EX);
                }
                $this->pluginCacheFileSet($_GET['path'], $new_office_content);
            }
        }
        die(json_encode($response));
    }
}