<div class="sixteen wide column" id="page">
	<div class="ui top attached tabular menu">
		<a class="<?php if ($tab == 'users') echo "active"?> item" href="/admin/users">
			<i class="users icon"></i>
			Users
		</a>
		<a class="<?php if ($tab == 'blog') echo "active"?> item" href="/admin/blog">
			<i class="book icon"></i>
			Blog
		</a>
		<a class="<?php if ($tab == 'forum') echo "active"?> item" href="/admin/forum">
			<i class="comments icon"></i>
			Forum
		</a>
	</div>
	<?php $this->load->view("tabs/$tab"); ?>
</div>
