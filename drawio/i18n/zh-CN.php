<?php
return array(
	"drawio.meta.name"				=> "draw.io",
	"drawio.meta.title"				=> "draw.io在线图表",
	"drawio.meta.desc"				=> "在线图表编辑",
	"drawio.file.name"              => "draw.io 图表",
	"drawio.share.title"            => "分享图表",
	"drawio.share.url"              => "分享链接",
	"drawio.Config.Theme"           => "界面主题",
	"drawio.Config.serverAddr"		=> "draw.io地址",
	"drawio.Config.serverAddrDesc"	=> "
	    <div class='can-select pt-10'>
	    由于draw.io占空间较大，默认使用官方编辑器的地址：<br/>
	    <div class='grey-8'>    https://www.draw.io</div><br/>
	    如果有本地化的需求，可以使用以下两种办法：<br/>
	    1. 到draw.io的<a href='https://github.com/jgraph/drawio/releases' target='_blank'>Release页面</a>下载draw.war，改后缀为zip后解压到plugins/drawio/static/，然后<span class='grey-8'>留空地址设置</span>。这种方法快速简单，但由于drawio的一些功能是用Servlet实现的，可能会有些功能不正常。<br/>
	    2. 本地部署Tomcat环境并设置好draw.io，将地址和相应端口号填入。可以<a href='https://github.com/jgraph/docker-drawio/blob/master/README.md' target='_blank'>使用Docker</a>快速部署。此办法可以使用drawio的完整功能。<br/>
	    </div>"
);