{* dbdSmarty *}
<!DOCTYPE html>
<html lang=""en>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Will Mason" />
{if $page_keys}
	<meta name="keywords" content="{$page_keys}" />
{/if}
{if $page_desc}
	<meta name="description" content="{$page_desc}" />
{/if}

	<!-- Fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/images/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="/images/ico/favicon.png">

	<title>{$app_name} - {$page_title|default:'Home'}</title>
</head>
<body id="hyduino-willandchi-com" class="{$page_class|default:'index default'}">
	{include file="global/_nav.tpl"}