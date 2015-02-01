<a href="/admin/users/add" id="add-user-button" class="ui labeled icon button">
	<i class="plus icon"></i>
	Add User
</a>
<div id="messages">
</div>
<div class="ui segment">
	<h3 class="ui header"><i class="code icon"></i>Developers</h3>
	<?php 
		if (isset($devs)) {
			$this->load->view('sections/user_cards', array('users' => $devs, 'edit' => $user->permissions['users']['update']));
		} else {
			echo "None\n"; 
		}
	?>
</div>
<div class="ui segment">
	<h3 class="ui header">Administrators</h3>
	<?php 
		if (isset($admins)) {
			$this->load->view('sections/user_cards', array('users' => $admins, 'edit' => $user->permissions['users']['update']));
		} else {
			echo "None\n"; 
		}
	?>
</div>
<div class="ui segment">
	<h3 class="ui header">Bloggers</h3>
	<?php 
		if (isset($bloggers)) {
			$this->load->view('sections/user_cards', array('users' => $bloggers, 'edit' => $user->permissions['users']['update']));
		} else {
			echo "None\n"; 
		}
	?>
</div>
<div class="ui segment">
	<h3 class="ui header">Advertisers</h3>
	<?php 
		if (isset($advertisers)) {
			$this->load->view('sections/user_cards', array('users' => $advertisers, 'edit' => $user->permissions['users']['update']));
		} else {
			echo "None\n"; 
		}
	?>
</div>
<div class="ui segment">
	<h3 class="ui header">Users</h3>
	<?php 
		if (isset($users)) {
			$this->load->view('sections/user_cards', array('users' => $users, 'edit' => $user->permissions['users']['update']));
		} else {
			echo "None\n"; 
		}
	?>
</div>
