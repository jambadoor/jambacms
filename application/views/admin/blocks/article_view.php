<?php
	$config = array(
		'divider_class' => 'right chevron icon divider',
		'crumbs' => array (
			'/admin/articles/view' => 'all',
			"/admin/articles/view/$article->category" => $article->category,
			'' => $article->headline
		)
	);
	echo $this->ui->indent_level;
	$this->ui->add_breadcrumb($config);
	echo $this->ui->indent_level;
	$this->ui->render();

?>
<div class="ui segment">
	<h3><?=$article->headline?></h3>
	<div>Name: <?=$article->name?></div>
	<div>Category: <?=$article->category?></div>
	<div>Keywords: <?=$article->keywords?></div>
	<div>Created On: <?=$article->date_created?></div>
	<div>Created By: <?=$article->created_by?></div>
	<div>Last Modified: <?=$article->last_modified?></div>
	<div>Last Modified By: <?=$article->last_modified_by?></div>
	<div><?=$article->content?></div>
</div>
