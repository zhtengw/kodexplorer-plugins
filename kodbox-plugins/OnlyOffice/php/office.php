<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ONLYOFFICE Document Server</title>
</head>
<body style="height: 100%; margin: 0;">
    <div id="placeholder" style="height: 100%"></div>
    <script type="text/javascript" src="<?php echo $option['apiServer']; ?>/web-apps/apps/api/documents/api.js"></script>

    <script type="text/javascript">

        window.docEditor = new DocsAPI.DocEditor("placeholder",
            {
                "document": {
                    "fileType": <?php var_export($option['fileType']); ?>,
                    "key": <?php var_export($option['key']); ?>,
                    "title": <?php var_export($option['title']); ?>,
                    "url": <?php var_export($option['url']); ?>,
                    "permissions": {
                        "download": <?php var_export($option['canDownload']); ?>,
                        "edit": <?php var_export($option['canEdit']); ?>,
                        "print": <?php var_export($option['canPrint']); ?>,
                    },
                },
                "documentType": <?php var_export($option['documentType']); ?>,
                "type": <?php var_export($option['type']); ?>,
                "editorConfig": {
                    "callbackUrl": <?php var_export($option['callbackUrl']); ?>,
                    "lang": <?php var_export($option['lang']); ?>,
                    "mode": <?php var_export($option['mode']); ?>,
                    "user": {
                        "id": <?php var_export($option['UID']); ?>,
                        "name": <?php var_export($option['user']); ?>
                    },
                    "customization": {
                        "chat": true,
                        "commentAuthorOnly": true,
                        "comments": true,
                        "compactHeader": <?php var_export($option['compact']); ?>,
                        "compactToolbar": false,
                        "help": false,
                        "toolbarNoTabs": false,
                        "hideRightMenu": <?php var_export($option['compact']); ?>,
                    },
                },
                "height": "100%",
                "width": "100%"
            });

    </script>
</body>
</html>