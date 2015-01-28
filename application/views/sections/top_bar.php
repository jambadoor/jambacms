<div class="ui fixed inverted main menu">
	<div class="container">
		<div class="title item">CI Template</div>
		<div class="item">A starting point.</div>
		<?php if (!$logged_in) : ?>
			<a href="login" class="launch item"><i class="settings icon"></i>Login</a>
		<?php else: ?>
			<div class="right floated launch item">
				<a href="/auth/logout">Logout</a>
			</div>
			<div class="right floated launch item">
				Logged in as <?=$user->username;?>
				<i class="settings icon"></i>
			</div>
		<?php endif; ?>

	</div>
</div>
