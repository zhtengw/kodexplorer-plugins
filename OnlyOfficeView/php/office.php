<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ONLYOFFICE Document Server</title>
</head>
<body style="height: 100%; margin: 0;">
    <div id="placeholder" style="height: 100%"></div>
    <script type="text/javascript" src="<?php echo $apiServer; ?>/web-apps/apps/api/documents/api.js"></script>

    <script type="text/javascript">

        window.docEditor = new DocsAPI.DocEditor("placeholder",
            {
                "document": {
                    "fileType": "<?php echo $fileExt; ?>",
                    "key": "<?php echo md5_file($path); ?>",
                    "title": " ",
                    "url": "<?php echo $fileUrl; ?>",
                     "permissions": {
                        "comment": true,
                        "download": true,
                        "edit": false,
                        "fillForms": true,
                        "print": true,
                        "review": false
                    },
                },
                "documentType": "<?php echo $this->getDocumentType($fileExt); ?>",
                "editorConfig": {
                    "callbackUrl": "",
                    "lang": "zh-CN",
                    "mode": "view",
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