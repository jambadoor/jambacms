<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<?php
		foreach ($metas as $meta) {
			echo $meta;
		}

		foreach ($css_plugins as $stylesheet) {
			echo '<link rel="stylesheet" href="/plugins/'.$stylesheet.'">';
		}

		foreach ($js_plugins as $script) {
			echo '<script src="/plugins/'.$script.'"></script>';
		}

		foreach ($stylesheets as $stylesheet) {
			echo '<link rel="stylesheet" href="/assets/css/'.$stylesheet.'">';
		}

		foreach ($scripts as $script) {
			echo '<script src="/assets/js/'.$script.'"></script>';
		}
	?>
</head>
<body>
	<?php 
		$this->load->view("layouts/$layout");
	?>
</body>
</html>
