<a href="/admin/content/add" id="add-content-button" class="ui labeled icon button">
	<i class="plus icon"></i>
	Add Content
</a>

<?php foreach ($content_sections as $section) : ?>
	<div id="<?=$section->name;?>_segment" class="ui segment">
		<h3 class="ui header"><?=$section->header;?></h3>
		<div class="content">
			<?=$section->content;?>
		</div>
		<a href="/admin/content/edit/<?=$section->name;?>" id="add-user-button" class="ui right floated labeled icon button">
			<i class="edit icon"></i>
			Edit
		</a>
		<a href="/admin/content/del/<?=$section->id?>" class="ui right floated icon button">
			<i class="erase icon"></i>
			Delete
		</a>
	</div>
<?php endforeach; ?>

