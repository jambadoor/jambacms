<div id="add-adlink-segment" class="ui segment">
	<h2 class="ui header"><i class="content icon"></i>New Adlink</h3>
	<form id="add-content-form" class="ui form" action="/admin/adlinks/create" method="POST" enctype="multipart/form-data">
		<div class="field">
			<label>Link URL</label>
			<input name="link_url" type="text">
		</div>
		<div class="field">
			<label>Redirect URL</label>
			<input type="text" name="redirect_url">
		</div>
		<div class="field">
			<label>Description</label>
			<textarea id="input" name="description"></textarea>
		</div>
		<input id="submit" type="submit" value="Submit" class="ui button">
	</form>
</div>
