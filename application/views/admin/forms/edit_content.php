<div id="edit-content-segment" class="ui segment">
	<h2 class="ui header"><i class="content icon"></i>Edit Content</h3>
	<form id="edit-content-form" class="ui form" action="/admin/content/update/<?=$content_section->name;?>" method="POST" enctype="multipart/form-data">
		<h3 class="ui header"><?=$content_section->header;?></h3>
		<div class="field">
			<textarea name="content"><?=$content_section->content;?></textarea>
		</div>
		<input type="submit" value="Submit" class="ui button">
	</form>
</div>
