<a href="/admin/blog/add" id="add-blog-button" class="ui labeled icon button">
	<i class="plus icon"></i>
	New Entry
</a>

<?php foreach ($blog_entries as $entry) : ?>
	<div id="<?=$entry->name;?>_segment" class="ui segment">
		<h3 class="ui header"><?=$entry->title;?></h3>
		<div class="content">
			<?=$entry->content;?>
		</div>
		<?php if ($user->permissions['blog']['update'] || $user->id == $entry->created_by) : ?>
		<a href="/admin/blog/edit/<?=$entry->name;?>" id="edit-entry-button" class="ui right floated labeled icon button">
			<i class="edit icon"></i>
			Edit
		</a>
		<?php endif; ?>
		<?php if ($user->permissions['blog']['delete'] || $user->id == $entry->created_by) : ?>
		<a href="/admin/blog/del/<?=$entry->name?>" class="ui right floated icon button">
			<i class="erase icon"></i>
			Delete
		</a>
		<?php endif; ?>
	</div>
<?php endforeach; ?>

