
<!-- pages/article -->
<div class="twelve wide column">
	<div class="ui breadcrumb">
		<a class="section" href="/articles">All</a>
		<div class="divider">/</div>
		<a class="section" href="/articles/<?=$article->category?>"><?=$article->category?></a>
		<div class="divider">/</div>
		<div class="section"><?=$article->headline?></div>
	</div>
</div>
<div class="four wide column"></div>
<div class="four wide column">
	<div class="ui segment">
		<h3>More <?=$article->category?></h3>
		<ul class="ui list">
<?php foreach ($articles[$article->category] as $name => $item) : ?>

			<li class="item">
				<a href="/articles/view/<?=$article->category?>/<?=$name?>"><?=$item->headline?></a>
			</li>
<?php endforeach; ?>

		</ul>
	</div>
</div>
<div class="twelve wide column">
	<div class="ui segment">
		<h3><?=$article->headline?></h3>
		<div><?=$article->content?></div>
		<div><?=$article->author?></div>
		<div><?=$article->last_modified?></div>
	</div>
</div>
