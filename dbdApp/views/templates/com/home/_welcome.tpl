{* dbdSmarty *}
<div id="welcome" class="container">
	<h1>{$title}</h1>
	<form name="power-switch" id="power-switch" method="post" action="/index/power">
		<div class="btn-group">
			<button name="status" value="off" class="btn btn-large active">Off</button>
			<button name="status" value="on" class="btn btn-large">On</button>
		</div>
	</form>
</div>