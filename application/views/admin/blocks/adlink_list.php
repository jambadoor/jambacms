<a href="/admin/adlinks/add" id="add-adlink-button" class="ui labeled icon button">
	<i class="plus icon"></i>
	New Entry
</a>

<?php foreach ($adlinks as $adlink) : ?>
<div class="ui segment">
	<div>Creator: <?=$adlink->created_by_name?></div>
	<div>Link URL: <?=$adlink->link_url?></div>
	<div>Redirect URL: <?=$adlink->redirect_url?></div>
	<div>Description: <?=$adlink->description?></div>
	<div>Total Hits: <?=$adlink->hits?></div>
<?php if ($user->permissions['adlinks']['update'] || $user->id == $adlink->created_by) : ?>
	<a href="/admin/adlinks/edit/<?=$adlink->link_url?>" id="edit-entry-button" class="ui right floated labeled icon button">
		<i class="edit icon"></i>
		Edit
	</a>
<?php endif; ?>
<?php if ($user->permissions['adlinks']['delete'] || $user->id == $adlink->created_by) : ?>
	<a href="/admin/adlinks/del/<?=$adlink->link_url?>" class="ui right floated icon button">
		<i class="erase icon"></i>
		Delete
	</a>
<?php endif; ?>
</div>
<?php endforeach; ?>
