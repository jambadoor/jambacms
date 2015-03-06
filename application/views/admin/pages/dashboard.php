<div class="sixteen wide column" id="page">
	<div id="dashboard-tabs" class="ui top attached tabular menu">
	<a href="/admin/home" id="home-tab" class="<?php if ($tab === 'home') echo 'active ';?>item">
			<i class="home icon"></i>
			Home
		</a>
		<a  href="/admin/users" id="users-tab" class="<?php if ($tab === 'users') echo 'active ';?>item">
			<i class="users icon"></i>
			Users
		</a>
		<a href="/admin/content" id="content-tab" class="<?php if ($tab === 'content') echo 'active ';?>item">
			<i class="content icon"></i>
			Content
		</a>
		<a href="/admin/blog" id="blog-tab" class="<?php if ($tab === 'blog') echo 'active ';?>item">
			<i class="book icon"></i>
			Blog
		</a>
		<a href="/admin/forum" id="forum-tab" class="<?php if ($tab === 'forum') echo 'active ';?>item">
			<i class="comments icon"></i>
			Forum
		</a>
		<a href="/admin/metrics" id="metrics-tab" class="<?php if ($tab === 'metrics') echo 'active ';?>item">
			<i class="bar chart icon"></i>
			Metrics
		</a>
		<a href="/admin/user" id="user-tab" class="<?php if ($tab === 'user') echo 'active ';?>item">
			<i class="user icon"></i>
			User
		</a>
		<a href="/admin/adlinks" id="ads-tab" class="<?php if ($tab === 'adlinks') echo 'active ';?>item">
			<i class="dollar icon"></i>
			Ads
		</a>
	</div>
	<div id="tab-content" class="ui bottom attached segment">
		<?php $this->load->view("$tab_content");?>
	</div>
</div>
