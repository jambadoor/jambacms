<?php
	$this->load->view('blocks/sticky_top_bar');
	echo '<div class="ui centered page grid">';
	$this->load->view("pages/$page");
	echo '</div>';
?>

