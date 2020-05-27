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

        var options = <?php echo json_encode($options); ?>;

        window.docEditor = new DocsAPI.DocEditor("placeholder", options);

    </script>
</body>
</html>