<div class="sixteen wide column" id="page">
	<div id="dashboard-tabs" class="ui top attached tabular menu">
		<a id="home-tab" class="active item">
			<i class="home icon"></i>
			Home
		</a>
		<a id="users-tab" class="item">
			<i class="users icon"></i>
			Users
		</a>
		<a id="blog-tab" class="item">
			<i class="book icon"></i>
			Blog
		</a>
		<a id="forum-tab" class="item">
			<i class="comments icon"></i>
			Forum
		</a>
		<a id="metrics-tab" class="item">
			<i class="comments icon"></i>
			Metrics
		</a>
		<a id="ads-tab" class="item">
			<i class="comments icon"></i>
			Ads
		</a>
	</div>
	<div id="tab-content" class="ui bottom attached segment">
		<?php $this->load->view('tabs/home'); ?>
	</div>
</div>
