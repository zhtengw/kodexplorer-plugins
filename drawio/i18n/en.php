<?php
return array(
	"drawio.meta.name"				=> "draw.io",
	"drawio.meta.title"				=> "draw.io Online Diagraming",
	"drawio.meta.desc"				=> "Online tools for Diagraming",
	"drawio.file.name"              => "draw.io Diagrams",
	"drawio.share.title"            => "Share Diagrams",
	"drawio.share.url"              => "URL for sharing",
	"drawio.Config.Theme"           => "Theme",
	"drawio.Config.serverAddr"		=> "draw.io address",
	"drawio.Config.serverAddrDesc"	=> "
	    <div class='can-select pt-10'>
	    Because of the large size of draw.io, official address is used by default: <br/>
	    <div class='grey-8'>    https://www.draw.io</div><br/>
	    But there are two methods to use this plugin locally:<br/>
	    1. Download draw.war from <a href='https://github.com/jgraph/drawio/releases' target='_blank'>Release页面</a>, change its extension to zip and decompress to 'plugins/drawio/static/'. The draw.io address should set to be<span class='grey-8'>empty</span>. This method is simple but some function written with Servlet will run abnormally.<br/>
	    2. Deploy Tomcat evironment and draw.io locally, then fill the blank by your address and port. You can <a href='https://github.com/jgraph/docker-drawio/blob/master/README.md' target='_blank'>use Docker</a>for quick deployment。Then you get fully functional draw.io.<br/>
	    </div>"
);
