<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<?php
		foreach ($metas as $meta) {
			echo $meta;
		}

		foreach ($stylesheets as $stylesheet) {
			echo $stylesheet;
		}

		foreach ($scripts as $script) {
			echo $script;
		}
	?>
</head>
<body>
	<?php 
		$this->load->view("layouts/$layout");
	?>
</body>
</html>
