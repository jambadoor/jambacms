<div id="top-spacer"></div>
<div class="four wide column">
	<div class="ui segment">
		<h3>More <?=$content_item->category?></h3>
		<div class="ui bulleted list">
		<?php foreach ($content[$content_item->category] as $name => $item) : ?>
			<div class="item">
				<a href="/mock/content/<?=$content_item->category?>/<?=$name?>"><?=$item->header?></a>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
	<div class="ui segment">
		<h3>Categories</h3>
		<div class="ui bulleted list">
		<?php foreach ($categories as $category) : ?>
			<div class="item">
				<a href="/mock/content/<?=$category?>/"><?=$category?></a>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</div>
<div class="twelve wide column">
	<div class="ui segment">
		<h3><?=$content_item->header?></h3>
		<p><?=$content_item->content?></p>
		<?=$content_item->last_modified?>
	</div>
</div>
