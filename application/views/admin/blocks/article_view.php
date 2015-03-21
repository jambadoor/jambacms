<div class="ui breadcrumb">
	<a class="section" href="/admin/articles/view">Articles</a>
	<span class="divider">/</span>
	<a class="section" href="/admin/articles/view/<?=$article->category?>"><?=$article->category?></a>
	<span class="divider">/</span>
	<span class="section"><?=$article->headline?></span>
</div>

<div class="ui segment">
	<h3><?=$article->headline?></h3>
	<div>Name: <?=$article->name?></div>
	<div>Category: <?=$article->category?></div>
	<div>Keywords: <?=$article->keywords?></div>
	<div>Created On: <?=$article->date_created?></div>
	<div>Author: <?=$article->author?></div>
	<div>Last Modified: <?=$article->last_modified?></div>
	<div>Last Modified By: <?=$article->last_modified_by?></div>
	<div><?=$article->content?></div>
</div>
