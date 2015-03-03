<div id="add-blog-entry-segment" class="ui segment">
	<h2 class="ui header"><i class="content icon"></i>New Entry</h3>
	<form id="add-blog-entry-form" class="ui form" action="/admin/blog/create" method="POST" enctype="multipart/form-data">
		<div class="field">
			<label>Name</label>
			<input name="name" type="text">
		</div>
		<div class="field">
			<label>Title</label>
			<input type="text" name="title">
		</div>
		<div class="field">
			<label>Content</label>
			<textarea id="input" name="content"></textarea>
			<script type="text/javascript" src="/assets/js/init_tinyeditor.js"></script>
		</div>
		<input id="submit" type="submit" value="Submit" class="ui button">
	</form>
</div>
