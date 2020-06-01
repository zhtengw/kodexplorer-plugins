<html><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $msg_title; ?></title>
	<style type="text/css">
		body{
			background-color:#f0f2f5;
			font-family: Verdana,"Lantinghei SC","Hiragino Sans GB","Microsoft Yahei",Helvetica,arial,sans-serif;
    		line-height: 1.5em;
		}
		body a,body a:hover{color: #1890ff;}
		.body-panel{
			width:70%;margin:10% auto 5% auto;
			font-size: 13px;
			color:#666;
			background:#fff;border-radius:4px;
			padding-top:50px;padding-bottom:100px;
			box-shadow: 0 5px 20px rgba(0,0,0,0.05);
		}
		.body-panel .check-result{text-align: center;color:#000;}
		.body-panel .check-result .icon{width:70px;height:70px;line-height:70px;font-size:30px;}
		.check-result-title{font-size: 24px;line-height: 32px;margin:20px 0;}
		.check-result-desc{
			color: #333;
			margin: 0 0 20px 0;
			background: #fafafa;
			font-size: 16px;
			width: 80%;
			margin: 0 auto;
			border-radius: 2px;
			padding: 24px 40px;
			text-align: left;
		}
		.error-info{
			border-left: 5px solid #1890ff;
			display: block;
			padding: 5px 10px;
			background: #fcfcfc;
			color: #666;
			word-break: break-all;
    		font-family: monospace;
		}
		.location-to{padding: 10px 0;color: #888;font-size: 13px;font-style: italic;}
		.icon{
		    font-family: FontAwesome;
		    display: inline-block;
		    width: 20px;
		    height: 20px;
		    background: rgba(0, 0, 0, 0.02);
		    text-align: center;
		    color: #666;
		    border-radius: 50%;
		    line-height: 20px;
		    font-size: 12px;
		}
    	.icon.icon-loading{
    		-webkit-animation: moveCircleLoopRight 1.4s infinite linear;
			animation: moveCircleLoopRight 1.4s infinite linear;
    	}
		.icon.icon-loading:before{content:"\f110";}
		.icon.icon-success{background:#52c41a;color:#fff;}
		.icon.icon-success:before{content:"\f00c";}
		.icon.icon-error{background:#f5222d;color:#fff;}
		.icon.icon-error:before{content:"\f00d";}
	</style>
</head>


<body>
	<div class="body-panel">
		<div class="check-result">
			<!-- <div class="icon icon-error"></div> -->
			<div class="check-result-title"><?php echo $msg_title; ?></div>
			<div class="check-result-desc">
				<span class="error-info"><?php echo $msg_content; ?></span>
				<div class="location-to"></div>
			</div>
		</div>
	</div>

	
</body></html>