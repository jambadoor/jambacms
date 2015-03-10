<div id="edit-content-segment" class="ui segment">
	<h2 class="ui header"><i class="content icon"></i>Edit Content</h3>
	<form id="edit-content-form" class="ui form" action="/admin/articles/update/<?=$article->name;?>" method="POST" enctype="multipart/form-data">
		<div class="field">
			<label>Name</label>
			<input name="name" type="text" value="<?=$article->name;?>">
		</div>
		<div class="field">
			<label>Headline</label>
			<input name="headline" type="text" value="<?=$article->headline;?>">
		</div>
		<div class="field">
			<label>Content</label>
			<textarea id="input" name="content"><?=$article->content;?></textarea>
			<script type="text/javascript" src="/assets/js/init_tinyeditor.js"></script>
		</div>
		<input id="submit" type="submit" value="Submit" class="ui button">
	</form>
</div>
