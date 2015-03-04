<?php if ($user->permissions['content']['create']) : ?>
	<a href="/admin/content/add" id="add-content-button" class="ui labeled icon button">
		<i class="plus icon"></i>
		Add Content
	</a>
<?php endif; ?>

<?php foreach ($content_sections as $section) : ?>
	<div id="<?=$section->name;?>_segment" class="ui segment">
		<h3 class="ui header"><?=$section->header;?></h3>
		<div class="content">
			<?=$section->content;?>
		</div>
		<?php if ($user->permissions['content']['update'] || $user->id == $section->created_by) : ?>
			<a href="/admin/content/edit/<?=$section->name;?>" id="add-user-button" class="ui right floated labeled icon button">
				<i class="edit icon"></i>
				Edit
			</a>
		<?php endif; ?>
		<?php if ($user->permissions['content']['delete'] || $user->id == $section->created_by) : ?>
			<a href="/admin/content/del/<?=$section->id?>" class="ui right floated icon button">
				<i class="erase icon"></i>
				Delete
			</a>
		<?php endif; ?>
	</div>
<?php endforeach; ?>

