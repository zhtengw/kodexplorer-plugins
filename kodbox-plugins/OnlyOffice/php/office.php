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
    
        var docEditor;

        var options = <?php echo json_encode($options); ?>;
        options.events = {};

        <?php  
            $history = $allHist[0];
            $historyData = $allHist[1];
        ?>
        <?php if ($history != null && $historyData != null): ?>
            options.events['onRequestHistory'] = function () {
                docEditor.refreshHistory(<?php echo json_encode($history) ?>);
            };
            options.events['onRequestHistoryData'] = function (event) {
                var ver = event.data;
                var histData = <?php echo json_encode($historyData) ?>;
                docEditor.setHistoryData(histData[ver]);
            };
            options.events['onRequestHistoryClose'] = function () {
                document.location.reload();
            };
        <?php endif; ?>
        docEditor = new DocsAPI.DocEditor("placeholder", options);

    </script>
</body>
</html>