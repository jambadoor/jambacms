<h3 class="ui header">Adlinks</h3>

<div>
<?php foreach ($adlinks as $adlink) : ?>
	<div class="ui segment">
		<div>Creator: <?=$adlink->created_by_name?></div>
		<div>Link URL: <?=$adlink->link_url?></div>
		<div>Redirect URL: <?=$adlink->redirect_url?></div>
		<div>Description: <?=$adlink->description?></div>
		<div>Total Hits: <?=$adlink->hits?></div>
	</div>
<?php endforeach; ?>

