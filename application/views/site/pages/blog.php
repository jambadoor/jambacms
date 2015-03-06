<div class="ui centered page grid" id="main-page-grid">
	<div class="sixteen wide column">
		<h3>Blog</h3>
		<?php foreach ($blog_entries as $entry) : ?>
			<div>
				<h2><?=$entry->title?></h2>
				<div>
					<?=$entry->content?>
				</div>
				<div>
					<div>Author: <?=$entry->created_by?></div>
					<div>Date: <?=$entry->date_created?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
