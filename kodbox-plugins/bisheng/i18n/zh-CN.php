<?php
return array(
	"bisheng.meta.name"				=> "毕升Office",
	"bisheng.meta.title"			=> "毕升Office在线编辑器",
	"bisheng.meta.desc"				=> "在线查看和编辑Office文档",
	"bisheng.viewAsPDF"             => "转成PDF预览",
	"bisheng.Config.previewMode"    => "预览模式",
	"bisheng.Config.apiServer"		=> "服务器接口",
	"bisheng.Config.apiServerDesc"	=> "
	    <div class='can-select pt-10'>
	    毕升Office API的地址，要求和当前打开KodExplorer的地址可以互相访问，否则将无法保存文档。<br/>
	    如果端口不是80或443，需要指明端口号。<br/>
	    <span class='grey-8'>服务端部署方式请参考<a href='https://www.bishengoffice.com/apps/blog/posts/install.html' target='_blank'>毕升官方文档</a>。</span></div>",
	"bisheng.Config.apiKey"         => "api key",
	"bisheng.Config.apiKeyDesc"     => "
	    <div class='can-select pt-10'>
	    如果部署的毕升Office服务器时开启了签名验证，请将正确的api key填写到此处，否则将会提示错误：<br/>
	    {\"code\": \"check callURL sign error\"}<br/>
	    {\"code\": \"check data sign error\"}<br/>
	    api key可以从[服务器接口]/app/console获得。</div>"
);