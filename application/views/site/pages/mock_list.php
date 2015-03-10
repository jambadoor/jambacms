<div id="top-spacer"></div>
<div class="sixteen wide column">
	<h1>Mockup List</h1>

	<div class="ui divided list">
		<?php foreach ($content as $key => $category) : ?>
			<div class="item">
				<h1><a href="/mock/content/<?=$key?>"><?=$key?></a></h1>
				<div class="list">
				<?php foreach ($category as $name => $record) : ?>
					<div class="item">
						<a href="/mock/content/<?=$key?>/<?=$name?>"><?=$record->name?></a>
					</div>
				<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
