<div id="edit-blog-entry-segment" class="ui segment">
	<h2 class="ui header"><i class="content icon"></i>Edit Entry</h3>
	<form id="edit-blog-entry-form" class="ui form" action="/admin/blog/update/<?=$blog_entry->name;?>" method="POST" enctype="multipart/form-data">
		<div class="field">
			<label>Name</label>
			<input name="name" type="text" value="<?=$blog_entry->name;?>">
		</div>
		<div class="field">
			<label>Title</label>
			<input name="header" type="text" value="<?=$blog_entry->title;?>">
		</div>
		<div class="field">
			<label>Content</label>
			<textarea id="input" name="content"><?=$blog_entry->content;?></textarea>
			<script type="text/javascript" src="/assets/js/init_tinyeditor.js"></script>
		</div>
		<input id="submit" type="submit" value="Submit" class="ui button">
	</form>
</div>
