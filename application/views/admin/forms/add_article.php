<div id="add-content-segment" class="ui segment">
	<h2 class="ui header"><i class="content icon"></i>Add Content</h3>
	<form id="add-content-form" class="ui form" action="/admin/articles/create" method="POST" enctype="multipart/form-data">
		<div class="field">
			<label>Name</label>
			<input name="name" type="text">
		</div>
		<div class="field">
			<label>Headline</label>
			<input type="text" name="headline">
		</div>
		<div class="field">
			<label>Content</label>
			<textarea id="input" name="content"></textarea>
			<script type="text/javascript" src="/assets/js/init_tinyeditor.js"></script>
		</div>
		<div class="field">
			<label>Category</label>
			<input type="text" name="category">
		</div>
		<div class="field">
			<label>Sub-Category</label>
			<input type="text" name="subcategory">
		</div>
		<input id="submit" type="submit" value="Submit" class="ui button">
	</form>
</div>
