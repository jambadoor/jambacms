<div id="top-spacer"></div>
<h1>Mockup List</h1>

<div class="ui divided list">
	<?php foreach ($categories as $key => $value) : ?>
		<div class="content">
		<h1><a href="mock/mockup/<?=$key?>"><?=$key?></h1>
		<div class="item">
			<div class="list">
			<?php foreach ($value as $thing) : ?>
				<div class="item">
					<a href="/mock/mockup/<?=$key?>/<?=$thing?>"><?=$thing?></a>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
?>
