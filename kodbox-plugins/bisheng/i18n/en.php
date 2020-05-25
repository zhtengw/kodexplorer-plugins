<?php
return array(
	"bisheng.meta.name"				=> "Bisheng Office",
	"bisheng.meta.title"			=> "Bisheng Office",
	"bisheng.meta.desc"				=> "View and Edit office documents online",
	"bisheng.viewAsPDF"             => "View as PDF",
	"bisheng.Config.previewMode"    => "Preview Mode",
    "bisheng.Config.apiServer"		=> "Server API Interface",
	"bisheng.Config.apiServerDesc"	=> "
	    <div class='can-select pt-10'>
	    The address of the bisheng API, KodExplorer can be accessed from this address either.<br/>
	    If the port used is other than 80 or 443, you should specify the port.<br/>
	    <span class='grey-8'>See <a href='https://www.bishengoffice.com/apps/blog/posts/install.html' target='_blank'>Bisheng offical documents</a> for how to deploy server.</span></div>",
	"bisheng.Config.apiKey"         => "api key",
	"bisheng.Config.apiKeyDesc"     => "
	    <div class='can-select pt-10'>
	    If Signature Verification is enable on the Bisheng Office server, please fill in the valid \"api key\" here, otherwise you will get such messages:<br/>
	    {\"code\": \"check callURL sign error\"}<br/>
	    {\"code\": \"check data sign error\"}<br/>
	    The \"api key\" can be found in [Server API Interface]/app/console.</div>"
);
