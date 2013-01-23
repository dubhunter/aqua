{* dbdSmarty *}
{assign var="page_title" value="$code - $name"}
{include file="global/_head.tpl"}
	<div id="errorDiv" class="container">
		<div class="alert alert-danger">
			<h1>{$code} - {$name}</h1>
			<p>{$msg}</p>
		</div>
	</div>
{include file="global/_foot.tpl"}