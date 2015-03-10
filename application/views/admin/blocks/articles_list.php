<?php if ($user->permissions['articles']['create']) : ?>
	<a href="/admin/articles/add" id="add-article-button" class="ui labeled icon button">
		<i class="plus icon"></i>
		Add Article
	</a>
<?php endif; ?>

<?php foreach ($articles as $article) : ?>
	<div id="<?=$article->name;?>-segment" class="ui segment">
		<h3><?=$article->headline;?></h3>
		<div class="content">
			<?=$article->content;?>
		</div>
		<div>Name: <?=$article->name?></div>
		<div>Created on <?=$article->date_created?> by <?=$article->created_by?></div>
		<div>Last modified on <?=$article->last_modified?> by <?=$article->last_modified_by?></div>
		<?php if ($user->permissions['articles']['update'] || $user->id == $article->created_by) : ?>
			<a href="/admin/articles/edit/<?=$article->name;?>" id="edit-article-button" class="ui right floated labeled icon button">
				<i class="edit icon"></i>
				Edit
			</a>
		<?php endif; ?>
		<?php if ($user->permissions['articles']['delete'] || $user->id == $article->created_by) : ?>
			<a href="/admin/articles/del/<?=$article->id?>" class="ui right floated icon button">
				<i class="erase icon"></i>
				Delete
			</a>
		<?php endif; ?>
	</div>
<?php endforeach; ?>

