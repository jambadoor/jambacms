<div class="sixteen wide column" id="page">
	<div id="dashboard-tabs" class="ui top attached tabular menu">
		<div class="<?php if ($tab === 'home') echo 'active ';?>item">
			<a href="/admin/home" id="home-tab">
				<i class="home icon"></i>
				Home
			</a>
		</div>
	<?php if ($user->permissions['users']['read']) : ?>
		<div id="users-tab" class="<?php if ($tab === 'users') echo 'active ';?>item">
			<a  href="/admin/users">
				<i class="users icon"></i>
				Users
			</a>
		</div>
	<?php endif; ?>
	<?php if ($user->permissions['articles']['read']) : ?>
		<div id="articles-tab" class="<?php if ($tab === 'articles') echo 'active ';?>item">
			<a href="/admin/articles">
				<i class="content icon"></i>
				Articles
			</a>
		</div>
	<?php endif; ?>
	<?php if ($user->permissions['forum']['read']) : ?>
		<div id="forum-tab" class="<?php if ($tab === 'forum') echo 'active ';?>item">
			<a href="/admin/forum">
				<i class="comments icon"></i>
				Forum
			</a>
		</div>
	<?php endif; ?>
	<?php if ($user->permissions['analytics']['read']) : ?>
		<div id="analytics-tab" class="<?php if ($tab === 'analytics') echo 'active ';?>item">
			<a href="/admin/analytics">
				<i class="bar chart icon"></i>
				Metrics
			</a>
		</div>
	<?php endif; ?>
		<div id="user-tab" class="<?php if ($tab === 'user') echo 'active ';?>item">
			<a href="/admin/user">
				<i class="user icon"></i>
				User
			</a>
		</div>
	<?php if ($user->permissions['adlinks']['read']) : ?>
		<div id="ads-tab" class="<?php if ($tab === 'adlinks') echo 'active ';?>item">
			<a href="/admin/adlinks">
				<i class="dollar icon"></i>
				Ads
			</a>
		</div>
	<?php endif; ?>
	</div>
	<div id="tab-content" class="ui bottom attached segment">
		<?php $this->load->view("$tab_content");?>
	</div>
</div>
