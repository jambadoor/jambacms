<div id="edit-adlink-segment" class="ui segment">
	<h2 class="ui header"><i class="content icon"></i>Edit Adlink</h3>
	<form id="edit-adlink-form" class="ui form" action="/admin/adlinks/update/<?=$adlink->link_url;?>" method="POST" enctype="multipart/form-data">
		<div class="field">
			<label>Link URL</label>
			<input name="link_url" type="text" value="<?=$adlink->link_url?>">
		</div>
		<div class="field">
			<label>Redirect URL</label>
			<input name="redirect_url" type="text" value="<?=$adlink->redirect_url?>">
		</div>
		<div class="field">
			<label>Description</label>
			<textarea id="input" name="description"><?=$adlink->description;?></textarea>
		</div>
		<input id="submit" type="submit" value="Submit" class="ui button">
	</form>
</div>
