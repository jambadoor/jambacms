<div id="top-spacer"></div>
<div class="twelve wide column">
	<div class="ui breadcrumb">
		<a class="section">Articles</a>
		<i class="right chevron icon divider"></i>
		<a class="section"><?=$article->category?></a>
		<i class="right chevron icon divider"></i>
		<a class="section"><?=$article->headline?></a>
	</div>
</div>
<div class="four wide column">
</div>
<div class="four wide column">
	<div class="ui segment">
		<h3>More <?=$article->category?></h3>
		<div class="ui bulleted list">
		<?php foreach ($articles[$article->category] as $name => $item) : ?>
			<div class="item">
				<a href="/articles/view/<?=$article->category?>/<?=$name?>"><?=$item->headline?></a>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
	<div class="ui segment">
		<h3>Categories</h3>
		<div class="ui bulleted list">
		<?php foreach ($categories as $category) : ?>
			<div class="item">
				<a href="/articles/view/<?=$category?>/"><?=$category?></a>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</div>
<div class="twelve wide column">
	<div class="ui segment">
		<h3><?=$article->headline?></h3>
		<p><?=$article->content?></p>
		<?=$article->last_modified?>
	</div>
</div>
