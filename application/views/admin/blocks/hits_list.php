<?php foreach ($hits as $hit) : ?>
	<div class="ui segment">
		<div>URL: <?=$hit->url?></div>
		<div>Timestamp: <?=$hit->timestamp?></div>
		<div>Referrer: <?=$hit->referrer?></div>
		<div>IP: <?=$hit->ip?></div>
		<div>User Agent: <?=$hit->user_agent?></div>
	</div>
<?php endforeach;?>
