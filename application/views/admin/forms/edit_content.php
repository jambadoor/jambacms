<div id="edit-content-segment" class="ui segment">
	<h2 class="ui header"><i class="content icon"></i>Edit Content</h3>
	<form id="edit-content-form" class="ui form" action="/admin/content/update/<?=$content_section->name;?>" method="POST" enctype="multipart/form-data">
		<div class="field">
			<label>Name</label>
			<input name="name" type="text" value="<?=$content_section->header;?>">
		</div>
		<div class="field">
			<label>Header</label>
			<input name="header" type="text" value="<?=$content_section->header;?>">
		</div>
		<div class="field">
			<label>Content</label>
			<textarea id="input" name="content"><?=$content_section->content;?></textarea>
			<script type="text/javascript" src="/assets/js/init_tinyeditor.js"></script>
		</div>
		<input id="submit" type="submit" value="Submit" class="ui button">
	</form>
</div>
