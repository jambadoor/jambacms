<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<?php
		foreach ($metas as $meta) {
			echo $meta."\n\t\t";
		}

		foreach ($css_plugins as $stylesheet) {
			echo '<link rel="stylesheet" href="/plugins/'.$stylesheet.'">'."\n\t";
		}

		foreach ($js_plugins as $script) {
			echo '<script src="/plugins/'.$script.'"></script>'."\n\t";
		}

		foreach ($stylesheets as $stylesheet) {
			echo '<link rel="stylesheet" href="/assets/css/'.$stylesheet.'">'."\n\t";
		}

		foreach ($scripts as $script) {
			echo '<script src="/assets/js/'.$script.'"></script>'."\n";
		}
	?>
</head>
<body>
<?php 
	$this->load->view("layouts/$layout");
?>
</body>
</html>
