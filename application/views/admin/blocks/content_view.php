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
	</div>
<?php endforeach; ?>

