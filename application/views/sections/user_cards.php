<div class="ui cards">

<?php foreach ($users as $user) : ?>

	<div id="<?="user_".$user->id;?>" class="user card">
		<div class="image">
			<img src="/assets/img/avatars/<?=$user->image_url?>">
		</div>
		<div class="content">
			<div class="header">
				<?=$user->first_name." ".$user->last_name."\n"?>
			</div>
			<div class="meta">
				<span>Since <?=$user->date_created?></span>
			</div>
			<div class="description">
				<?=$user->about."\n"?>
			</div>
		</div>

		<?php if ($edit) : ?>
			<div class="ui two bottom attached buttons">
				<a href="/admin/users/edit/<?=$user->id?>" class="ui button">
					<i class="edit icon"></i>
					Edit
				</a>
				<a href="/admin/users/delete/<?$user->id?>" class="ui button">
					<i class="erase icon"></i>
					Delete
				</a>
			</div>
		<?php endif; ?>

	</div>

<?php	endforeach; ?>

</div>
