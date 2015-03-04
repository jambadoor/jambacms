<div class="ui cards">

<?php foreach ($users as $usr) : ?>

	<div id="<?="user_".$usr->id;?>" class="user card">
		<div class="image">
			<img src="/assets/img/avatars/<?=$usr->image_url?>">
		</div>
		<div class="content">
			<div class="header">
				<?=$usr->first_name." ".$usr->last_name."\n"?>
			</div>
			<div class="meta">
				<div><?=$usr->username?></div>
				<div><?=$usr->email?></div>
				<div>Joined <?=$usr->date_created?></div>
				<div>Last logged in <?=$usr->last_login?></div>
			</div>
			<div class="description">
				<?=$usr->about."\n"?>
			</div>
		</div>

<?php 
	if (isset($user->permissions)) {
			if ($user->permissions['users']['update']) : ?>
				<div class="ui two bottom attached buttons">
					<a href="/admin/users/edit/<?=$usr->id?>" class="ui button">
						<i class="edit icon"></i>
						Edit
					</a>
					<a href="/admin/users/del/<?=$usr->id?>" class="ui button">
						<i class="erase icon"></i>
						Delete
					</a>
				</div>
		<?php endif; 
		}?>

	</div>

<?php	endforeach; ?>

</div>
