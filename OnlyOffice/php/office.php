<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ONLYOFFICE Document Server</title>
</head>
<body style="height: 100%; margin: 0;">
    <div id="placeholder" style="height: 100%"></div>
    <script type="text/javascript" src="<?php echo $config['apiServer']; ?>/web-apps/apps/api/documents/api.js"></script>

    <script type="text/javascript">

        window.docEditor = new DocsAPI.DocEditor("placeholder",
            {
                "document": {
                    "fileType": "<?php echo $fileExt; ?>",
                    "key": "<?php echo md5_file($path); ?>",
                    "title": " ",//<?php echo $fileName; ?>",
                    "url": "<?php echo $fileUrl; ?>",
                },
                "documentType": "<?php echo $this->getDocumentType($fileExt); ?>",
                "editorConfig": {
                    "callbackUrl": "<?php echo $cbUrl; ?>",
                    "lang": "zh-CN",
                    "customization": {
                        "chat": false,
                        "commentAuthorOnly": false,
                        "comments": false,
                        "compactHeader": true,
                        "compactToolbar": false,
                        "help": false,
                        "toolbarNoTabs": false,
                        "hideRightMenu": true,
                    },
                },
                "height": "100%",
                "width": "100%"
            });

    </script>
</body>
</html>