<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
<?php
	foreach ($metas as $meta) {
		echo $meta;
		echo "\n";
	}

	foreach ($css_plugins as $stylesheet) {
		echo '<link rel="stylesheet" href="/plugins/'.$stylesheet.'">';
		echo "\n";
	}

	foreach ($js_plugins as $script) {
		echo '<script src="/plugins/'.$script.'"></script>';
		echo "\n";
	}

	foreach ($stylesheets as $stylesheet) {
		echo '<link rel="stylesheet" href="/assets/css/'.$stylesheet.'">';
		echo "\n";
	}

	foreach ($scripts as $script) {
		echo '<script src="/assets/js/'.$script.'"></script>';
		echo "\n";
	}
?>
</head>
<body>
<?php 
	$this->load->view("layouts/$layout");
?>
</body>
</html>
